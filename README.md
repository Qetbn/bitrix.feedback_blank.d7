# bitrix.feedback_blank.d7
Простой компонент обратной связи для Битрикса на D7.

---

### $arParams:
  - IBLOCK_ID - ID инфоблока для сохранения формы обратной связи
  - EVENT - название события, генерируемого при сохранении результата формы обратной связи

### $arResult:
  - error - массив ошибок. В случае если ошибок нет, то он пустой.
  - send - true если была заполнена форма (не означает что прошла валидацию)

### Используемые поля и свойства инфоблока:
  - NAME - имя
  - PREVIEW_TEXT - текст сообщения
  - PROPERTY_EMAIL - E-Mail

### Генерируемые поля почтового события:
  - #NAME#
  - #EMAIL#
  - #MESSAGE#

Для успешной валидации в POST/GET параметрах должен отправляться bitrix_sessid() посредством bitrix_sessid_post() или bitrix_sessid_get().

---

### Пример шаблона компонента:

```html
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
```
