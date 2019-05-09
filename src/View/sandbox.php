<h1>Sandbox</h1>

<?php
$model = new \App\Model\UserModel(App::database());
$model->upsert(['user_id' => 30, 'email' => 'foo@bar.fdsfdsf'], 10);
