<?php
// login.php
session_start();
require_once 'config/database.php';

$err = '';
$username_display = 'hajarminsaf@gmail.com';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = 'hajarminsaf@gmail.com';
    $password = $_POST['password'] ?? '';

    if ($password == '') {
        $err = 'Veuillez entrer votre mot de passe.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :u OR email = :u LIMIT 1");
        $stmt->execute([':u' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: dashboard.php');
            exit;
        } else {
            $err = 'Mot de passe incorrect.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* CSS INLINE POUR TEST */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color:whitesmoke;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        form {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 400px;
        }
        
        form h2 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: 600;
        }
        
        .email-label {
            color: #555;
            margin-bottom: 5px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .email-display {
            background: #f8f9fa;
            padding: 14px;
            border-radius: 10px;
            margin-bottom: 24px;
            color: #333;
            font-size: 16px;
            border: 2px solid #e1e5e9;
        }
        
        .password-label {
            color: #555;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
        }
        
        input[type="password"] {
            width: 100%;
            padding: 14px;
            margin-bottom: 24px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 16px;
            background: #f8f9fa;
        }
        
        button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #3496a1ff 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }
        
        .error {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border-left: 4px solid #c33;
        }
    </style>
</head>
<body>
    <form method="post" action="">
        <h2>Connexion</h2>
        
        <?php if ($err): ?>
            <div class="error"><?php echo htmlspecialchars($err); ?></div>
        <?php endif; ?>
        
        <div class="email-label">Adresse email</div>
        <div class="email-display"><?php echo htmlspecialchars($username_display); ?></div>
        <input type="hidden" name="username" value="<?php echo htmlspecialchars($username_display); ?>">
        
        <label class="password-label">Mot de passe</label>
        <input type="password" 
               name="password" 
               required 
               placeholder="Entrez votre mot de passe">
        
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>