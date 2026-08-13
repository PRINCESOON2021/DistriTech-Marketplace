<?php
declare(strict_types=1);
require dirname(__DIR__) . '/app/security.php'; secure_session_start();
require dirname(__DIR__) . '/app/helpers.php';
$scope = preg_replace('/[^a-z-]/', '', (string) ($_GET['scope'] ?? 'form')) ?: 'form';
$code = captcha_code($scope);
header('Content-Type: image/svg+xml; charset=UTF-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
$esc = static fn(string $v): string => htmlspecialchars($v, ENT_QUOTES | ENT_XML1, 'UTF-8');
$noise = '';
for ($i=0;$i<7;$i++) { $y1=random_int(5,59);$y2=random_int(5,59);$noise.='<path d="M0 '.$y1.' Q90 '.random_int(0,64).' 180 '.$y2.'" fill="none" stroke="'.($i%2?'#d96815':'#587a88').'" stroke-width="'.random_int(1,2).'" opacity=".42"/>'; }
for ($i=0;$i<38;$i++) $noise.='<circle cx="'.random_int(3,177).'" cy="'.random_int(3,61).'" r="'.random_int(1,2).'" fill="'.($i%2?'#e87817':'#5d8798').'" opacity=".45"/>';
$letters='';
foreach(str_split($code) as $i=>$char){$x=23+$i*26;$y=random_int(39,49);$rotation=random_int(-16,16);$letters.='<text x="'.$x.'" y="'.$y.'" transform="rotate('.$rotation.' '.$x.' '.$y.')">'.$esc($char).'</text>';}
echo '<svg xmlns="http://www.w3.org/2000/svg" width="180" height="64" viewBox="0 0 180 64"><defs><linearGradient id="g"><stop stop-color="#fff7ef"/><stop offset="1" stop-color="#e8eef1"/></linearGradient></defs><rect width="180" height="64" rx="9" fill="url(#g)"/><g>'.$noise.'</g><g font-family="Arial,sans-serif" font-size="28" font-weight="900" fill="#2d211b" letter-spacing="3">'.$letters.'</g><rect x=".5" y=".5" width="179" height="63" rx="8.5" fill="none" stroke="#dc9a62"/></svg>';
