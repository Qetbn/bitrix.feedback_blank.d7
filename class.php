<?
use \Bitrix\Main\Application;
use \Bitrix\Main\Loader;

class FeedbackComponent extends CBitrixComponent
{
    public function onPrepareComponentParams($params)
    {
        $params["IBLOCK_ID"] = 1;
        $params["EVENT"] = "FEEDBACK";
        return $params;
    }

    public function executeComponent()
    {
        $context = Application::getInstance()->getContext();
        $request = $context->getRequest();
        $this->arResult["send"] = false;
        $this->arResult["errors"] = array();

        if ($request->get("send") == "feedback") {
            $this->arResult["send"] = true;
            $this->arResult["form"] = array(
                'name' => htmlspecialchars($request->get("name")),
                'email' => htmlspecialchars($request->get("email")),
                'message' => htmlspecialchars($request->get("message")),
            );
            if (!strlen($this->arResult["form"]['name']) ||
                !strlen($this->arResult["form"]['message']) ||
                !check_email($this->arResult["form"]['email']) ||
                !check_bitrix_sessid()
            ) {
                $this->arResult["error"] = true;
                $errors = array(
                    'Пожалуйста, представьтесь.' => !strlen($this->arResult["form"]['name']),
                    'Вы не ввели текст сообщения.' => !strlen($this->arResult["form"]['message']),
                    'Введите действительный E-Mail.' => !check_email($this->arResult["form"]['email']),
                    'Срок вашей сессии истёк, перегрузите страницу.' => !check_bitrix_sessid()
                );
                foreach ($errors as $k => $v) {
                    if ($v) {
                        $this->arResult["errors"][] = $k;
                    }
                }
            } else {
                /**
                 * Сохранить элемент инфоблока
                 */
                $arEventFields = array();
                if ($this->arParams["IBLOCK_ID"]) {
                    Loader::includeModule("iblock");
                    $arElementFields = array(
                        'IBLOCK_ID' => $this->arParams["IBLOCK_ID"],
                        'ACTIVE' => 'Y',
                        'NAME' => $this->arResult["form"]['name'],
                        'PREVIEW_TEXT' => $this->arResult["form"]['message'],
                        'PROPERTY_VALUES' => array('EMAIL' => $this->arResult["form"]['email'])
                    );
                    $element = new CiblockElement();
                    $arEventFields["ID"] = $element->Add($arElementFields);
                }
                /**
                 * Отправить письмо
                 */
                if ($this->arParams["EVENT"]) {
                    foreach ($this->arResult["form"] as $k => $v) {
                        $arEventFields[strtoupper($k)] = $v;
                    }
                    \CEvent::Send($this->arParams["EVENT"], array(SITE_ID), $arEventFields);
                }

            }
        }
        $this->IncludeComponentTemplate();
    }
}


?>
