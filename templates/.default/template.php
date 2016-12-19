<? if ($arResult["send"]): ?>
    <? if (!empty($arResult["errors"])): ?>
        <div class="error">
            <? foreach ($arResult["errors"] as $err): ?>
                <?= $err ?><br/>
            <? endforeach ?>
        </div>
    <? else: ?>
        OK
    <? endif ?>
<? else: ?>
    <form id="contact-form" action="<?=$APPLICATION->GetCurPage()?>">
        <div class="input-line">
            <input type="text" name="name">
            <span>Имя</span>
        </div>
        <div class="input-line">
            <input type="text" name="email">
            <span>Email</span>
        </div>
        <div class="input-line textarea">
            <textarea name="message" placeholder=""></textarea>
            <span>Сообщение</span>
        </div>
        <?= bitrix_sessid_post() ?>
        <input type="hidden" name="send" value="feedback">
        <input type="submit" value="Отправить">
    </form>
<? endif ?>
