Привет, <?php echo $user['login']; ?>!
<h3>Твои диалоги</h3>
<hr>
<div id="dialogues" class="direct-chat direct-chat-primary" data-ng-init="getDialogues();
        setIntGD();"  data-ng-controller="Dialogue">
    <div class="sortig">
        Сортировать по дате: <a href="javascript:void(0);" data-ng-click="changeSorting('desc')" data-ng-if="sort.type == 'asc'">по убывающей</a>
        <a href="javascript:void(0);" data-ng-click="changeSorting('asc')" data-ng-if="sort.type == 'desc'">по возрастающей</a>
        <div>
    <div data-ng-if="dialogues.length > 0" class="direct-char-messages">
        <div  style="position:relative;" 
              class="direct-chat-msg" data-ng-repeat="d in dialogues">
            <small>  Собеседники: <span data-ng-repeat="m in d.members">{{m.login}}</span></small>
            <div class="direct-chat-info clearfix">
                <span class="direct-chat-name pull-left">
                    {{d.login}}
                </span>
                <span class="direct-chat-timestamp pull-right">{{d.stamp}}</span>
            </div><!-- /.direct-chat-info -->
            <img class="direct-chat-img" 
                 data-ng-src="/{{d.avatar}}" 
                 alt="message user image"><!-- /.direct-chat-img -->

            <a href="/user/dialogue/{{d.ud_id}}">
                <div class="direct-chat-text">
                    {{d.data| cut:true:200:' ...'}}
                    <br>
                </div><!-- /.direct-chat-text -->
            </a>
            <div class="small">
                (статус сообщения: {{d.msg_status}}) 
                        <span class="small" 
                              data-ng-click="deleteDialogue($index)" 
                              style="cursor:pointer;">Удалить диалог</span>
            </div>
        </div>
    </div>
    <div data-ng-if="dialogues.length == 0">
        <p>У вас пока нет диалогов</p>
    </div>
</div>
