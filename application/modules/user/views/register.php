<?php
    echo form_open_multipart();
    if(!empty($msg))
        echo message('error', $msg['title'], $msg['message']);
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
        echo form_label('E-mail', 'email');
        ?>
    <input type="text" id="email" name="email" class="form-control" value="<?php echo set_value('email'); ?>">
    <?php echo form_error('email'); ?>
</div>

<div class="form-group">
    <?php 
        echo form_label('Файл', 'file');
        echo form_upload(['name'=>'file', 'id'=>'file']);
    ?>
    <?php echo form_error('file'); ?>
</div>

<div class="form-group">
    <?php
        echo form_label('Пароль', 'pass');
        echo form_password(['name'=>'password', 'id'=>'pass', 'class' => 'form-control']);
    ?>
    <?php echo form_error('pass'); ?>
</div>

<div class="form-group">
    <?php 
        echo form_label('Повторите пароль', 'passValid');
        echo form_password(['name'=>'passValid', 'id'=>'passValid', 'class' => 'form-control']);
    ?>
    <?php echo form_error('passValid'); ?>
</div>

<div class="form-group">
    <?php echo form_submit(['class'=>'btn btn-success '], 'Зарегистрироваться');?>
</div>

<?php    
    form_close();
    ?>