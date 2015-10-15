<body>
   <div id="wrapper" class="container">
       <div class='col-md-6 col-md-offset-3'>
           <div class='box with-border'>
               
               <div class="box-header with-border">
                  <h3 class="box-title">
                    <?php echo $title; ?>
                  </h3>
                </div>
               
               <div class="box-body">
                <div class="col-md-12">
                    <?php if(!isset($u_session['login'])):
                        echo anchor('/user/login', 'Авторизироваться');
                        echo ' | ';
                        echo anchor('/user/register', 'Зарегистрироваться');
                    else:
                        echo anchor('/user', 'Моя страница');
                        echo ' | ';
                        echo anchor('/user/logout', 'Выход');
                    endif;?>
                </div>
                <div class="col-md-12">
                     <?php echo $body;?>
                </div>
               </div>
           </div>
       </div>
   </div>
</body>