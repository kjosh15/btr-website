<?php
declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /#connect');
    exit;
}

$required = ['name', 'role', 'organization', 'email', 'interest'];
$lang = strtolower(trim((string)($_POST['lang'] ?? 'en')));
if (!in_array($lang, ['en', 'is'], true)) {
    $lang = 'en';
}
$data = [];
foreach (['name', 'role', 'organization', 'email', 'inquiry_type', 'interest', 'timeline', 'notes'] as $field) {
    $value = trim(filter_input(INPUT_POST, $field, FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '');
    $data[$field] = $value;
}

$errors = [];
foreach ($required as $field) {
    if ($data[$field] === '') {
        $errors[] = $field;
    }
}

if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'email';
}

$to = 'josh@josh.is';
$fromAddress = 'contact@btr.is';
$subject = 'New inquiry from BTR.is';

ini_set('sendmail_from', $fromAddress);

$body = implode("\n", [
    "Name: {$data['name']}",
    "Role / Title: {$data['role']}",
    "Organization: {$data['organization']}",
    "Email: {$data['email']}",
    "Inquiry Type: {$data['inquiry_type']}",
    "Interest / Request:\n{$data['interest']}",
    "Timeline: {$data['timeline']}",
    "Additional notes:\n{$data['notes']}",
    "Submitted: " . date('c'),
]);

$headers = [
    'From' => "BTR.is <{$fromAddress}>",
    'Reply-To' => "{$data['name']} <{$data['email']}>",
    'Content-Type' => 'text/plain; charset=UTF-8',
    'X-Mailer' => 'PHP/' . phpversion(),
];
$headersString = '';
foreach ($headers as $key => $value) {
    $headersString .= $key . ': ' . $value . "\r\n";
}

$strings = [
    'is' => [
        'successTitle' => 'Takk fyrir!',
        'successBody' => 'Skilaboðin þín hafa verið móttekin og við svörum eins fljótt og auðið er.',
        'errorTitle' => 'Villa kom upp',
        'errorBody' => 'Vinsamlegast reyndu aftur eða sendu okkur línu á <a href="mailto:josh@josh.is">josh@josh.is</a>.',
        'backLabel' => 'Til baka á síðuna',
    ],
    'en' => [
        'successTitle' => 'Thank you!',
        'successBody' => 'Your message has been received and we will reply as soon as possible.',
        'errorTitle' => 'Something went wrong',
        'errorBody' => 'Please try again or email us at <a href="mailto:josh@josh.is">josh@josh.is</a>.',
        'backLabel' => 'Back to the site',
    ],
];

$languageStrings = $strings[$lang];

$logDir = dirname(__DIR__) . '/contact_logs';
if (!is_dir($logDir)) {
    mkdir($logDir, 0775, true);
}

$success = empty($errors)
    ? mail($to, $subject, $body, $headersString, '-f' . $fromAddress)
    : false;

$logEntry = json_encode([
    'timestamp' => date('c'),
    'lang' => $lang,
    'email' => $data['email'],
    'success' => $success,
    'errors' => $errors,
    'mail_error' => $success ? null : error_get_last(),
], JSON_PRETTY_PRINT);
file_put_contents($logDir . '/contact.log', $logEntry . PHP_EOL, FILE_APPEND);
$statusTitle = $success ? $languageStrings['successTitle'] : $languageStrings['errorTitle'];
$statusBody = $success ? $languageStrings['successBody'] : $languageStrings['errorBody'];

if (!$success && empty($errors)) {
    $errors[] = 'mail';
}

?>
<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($lang); ?>">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo htmlspecialchars($statusTitle); ?> — BTR.is</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      background: #f6f7fb;
      color: #0f172a;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card {
      background: #fff;
      border-radius: 24px;
      padding: 3rem;
      box-shadow: 0 20px 40px rgba(15, 23, 42, 0.12);
      max-width: 480px;
      width: 90%;
      text-align: center;
    }
    h1 {
      font-size: 1.75rem;
      margin-bottom: 1rem;
    }
    p {
      line-height: 1.6;
      color: #475569;
    }
    a {
      color: #175cd3;
    }
    .btn {
      margin-top: 1.5rem;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 0.75rem 1.5rem;
      border-radius: 999px;
      background: #175cd3;
      color: #fff;
      text-decoration: none;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <div class="card">
    <h1><?php echo htmlspecialchars($statusTitle); ?></h1>
    <p><?php echo $statusBody; ?></p>
    <a class="btn" href="/#connect"><?php echo $languageStrings['backLabel']; ?></a>
  </div>
</body>
</html>
