<?php include('../includes/header.php'); ?>

<div style="max-width: 400px; margin: 50px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
    <h2 style="text-align: center; color: #2d5a27;">User Login</h2>
    <form action="check_login.php" method="POST">
        <div style="margin-bottom: 15px;">
            <label>Email Address</label>
            <input type="email" name="email" required style="width: 100%; padding: 10px; margin-top: 5px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label>Password</label>
            <input type="password" name="password" required style="width: 100%; padding: 10px; margin-top: 5px;">
        </div>
        <button type="submit" style="width: 100%; padding: 12px; background: #2d5a27; color: white; border: none; border-radius: 5px; cursor: pointer;">Login to System</button>
    </form>
</div>

<?php include('../includes/footer.php'); ?>