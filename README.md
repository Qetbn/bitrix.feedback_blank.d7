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
