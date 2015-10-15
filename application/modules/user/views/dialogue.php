<div data-ng-init="getDialogueMessages(<?php echo $id; ?>); setIntDM(<?php echo $id; ?>);" data-ng-controller="Dialogue">
    <div class="box-body" >
        <div id="dialogues" class="direct-chat direct-chat-primary">
            <div data-ng-if="dialogues.length > 0" class="direct-char-messages">
                <div style="position:relative;" 
                     data-ng-class="d.login == '<?php echo $user['login']; ?>'?'direct-chat-msg':'direct - chat - msg  right' " 
                     data-ng-repeat="d in dialogues">

                    <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-left">
                            {{d.login}}
                        </span>
                        <span class="direct-chat-timestamp pull-right">{{d.stamp}}</span>
                    </div><!-- /.direct-chat-info -->
                    <img class="direct-chat-img" 
                         data-ng-src="/{{d.avatar}}" 
                         alt="message user image"><!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                        
                    <button data-ng-click="deleteMessage($index)"
                            class="del-chat btn btn-box-tool">
                        <i class="fa fa-times"></i>
                    </button>
                        {{d.data}}
                    </div><!-- /.direct-chat-text -->
                    <div class="small">
                        (статус: {{d.msg_status}})
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <form name="sendmessage" action="#" method="post">
            <div class="input-group">
                <input type="text" data-ng-model="form.data" name="message" placeholder="Введите свое сообщение" class="form-control">
                <input type="hidden" name='dialogue_id' data-ng-init="form.dialogue_id = <?php echo $id; ?>" data-ng-model="form.dialogue_id">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary btn-flat" data-ng-click="send()">Отправить</button>
                </span>
            </div>
        </form>
    </div>
</div>