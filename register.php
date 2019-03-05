<?php
require_once 'core/init.php';

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {

        echo "I have been run";

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users'
            ),
            'password' => array(
                'required' => true,
                'min' => 6
            ),
            'password_verify' => array(
                'required' => true,
                'matches' => 'password'
            ),
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' => 50
            )
        ));

        if ($validate->passed()) {
            echo "Passed";
        } else {
            foreach($validation->errors() as $error) {
                echo $error, "<br>";
            }
        }
    }
}
?>

<form action="" method="post">
    <div class="field">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php echo escape(Input::get("username"));?>" autocomplete="off">
    </div>
    <div class="field">
        <label for="password">Choose a password</label>
        <input type="password" name="password" id="password" value="" autocomplete="off">
    </div>
    <div class="field">
        <label for="password_verify">Verify Password</label>
        <input type="password" name="password_verify" id="password_verify" value="" autocomplete="off">
    </div>
    <div class="field">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="<?php echo escape(Input::get("name"));?>" autocomplete="off">
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="Register">
</form>