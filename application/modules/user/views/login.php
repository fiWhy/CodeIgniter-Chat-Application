<?php
    echo form_open();
    if(!empty($error))
        echo message('error', 'Ошибка авторизации', $error);
    
    ?>

<div class="form-group">
    <?php 
        echo form_label('Логин', 'login');
    ?>
    <input type="text" id="login" name="login" class="form-control" value="<?php echo set_value('login'); ?>">
    <?php echo form_error('login'); ?>
</div>


<div class="form-group">
    <?php
        echo form_label('Пароль', 'pass');
        echo form_password(['name'=>'password', 'id'=>'pass', 'class' => 'form-control']);
    ?>
    <?php echo form_error('pass'); ?>
</div>


<div class="form-group">
    <?php echo form_submit(['class'=>'btn btn-primary '], 'Авторизация');?>
</div>

<?php    
    form_close();
    ?>