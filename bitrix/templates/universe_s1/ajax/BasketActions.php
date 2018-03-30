<?php
namespace intec\universe\template\ajax;

use intec\Core;
use intec\core\handling\Actions;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Encoding;
use intec\core\helpers\Type;
use Bitrix\Main\Loader;
use Bitrix\Sale\Basket;
use Bitrix\Sale\Fuser;
use Bitrix\Currency\CurrencyManager;
use Bitrix\Main\Context;

class BasketActions extends Actions
{
    /**
     * @var Basket
     */
    protected $basket = null;

    /**
     * @inheritdoc
     */
    public function beforeAction ($action)
    {
        if (parent::beforeAction($action)) {
            if (!Loader::includeModule('intec.core')
                || !Loader::includeModule('intec.constructor')
                || !Loader::includeModule('sale')
                || !Loader::includeModule('iblock')
                || !Loader::includeModule('catalog')
            ) return false;

            return true;
        }

        return false;
    }

    /**
     * Возвращает данные запроса.
     * @return array|mixed
     */
    protected function getData()
    {
        $data = Core::$app->request->post('data');
        return Type::isArray($data) ? $data : [];
    }

    /**
     * Возвращает экземпляр корзины текущего пользователя.
     * @return Basket
     */
    protected function getBasket()
    {
        if ($this->basket === null)
            $this->basket = Basket::loadItemsForFUser(
                Fuser::getId(),
                Context::getCurrent()->getSite()
            );

        return $this->basket;
    }

    /**
     * Добавление товара в корзину.
     * @post int $id Идентификатор элемента инфоблока.
     * @post int $quantity Количество. Необязательно.
     * @post array $properties Свойства, добавляемые в корзину. Необязательны.
     * @post string $currency Код валюты. Необязателен.
     * @post string $delay Добавить в отложенные. (Y/N).
     * @return bool
     */
    public function actionAdd()
    {
        $data = $this->getData();
        $id = ArrayHelper::getValue($data, 'id');
        $id = Type::toInteger($id);
        $quantity = ArrayHelper::getValue($data, 'quantity');
        $quantity = Type::toInteger($quantity);
        $quantity = $quantity < 1 ? 1 : $quantity;
        $properties = ArrayHelper::getValue($data, 'properties');
        $currency = ArrayHelper::getValue($data, 'currency');
        $delay = ArrayHelper::getValue($data, 'delay');
        $delay = $delay == 'Y' ? 'Y' : 'N';

        if (empty($id))
            return false;

        if (empty($currency))
            $currency = CurrencyManager::getBaseCurrency();

        $arElement = \CIBlockElement::GetByID($id)->GetNext();

        if (empty($arElement))
            return false;

        $arProduct = \CCatalogSku::GetProductInfo($id);

        $basket = $this->getBasket();

        if ($item = $basket->getExistsItem('catalog', $id)) {
            $item->setFields(['DELAY' => $delay]);
        } else {
            $item = $basket->createItem('catalog', $id);
            $item->setFields([
                'QUANTITY' => $quantity,
                'CURRENCY' => $currency,
                'DELAY' => $delay,
                'LID' => Context::getCurrent()->getSite(),
                'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider',
            ]);
        }

        $basket->save();

        if(!empty($arProduct) && Type::isArray($properties)){
            $properties = \CIBlockPriceTools::GetOfferProperties(
                $id,
                $arElement['IBLOCK_ID'],
                $properties
            );

            if (!empty($properties)) {
                $collection = $item->getPropertyCollection();
                $collection->setProperty($properties);
                $collection->save();
            }
        }

        return true;

    }

    /**
     * Возвращает элементы корзины.
     * @return array
     */
    public function actionGet()
    {
        $basket = $this->getBasket();
        $result = [];

        foreach ($basket as $item) {
            $values = $item->getFields()->getValues();
            $array = [
                'id' => ArrayHelper::getValue($values, 'PRODUCT_ID'),
                'name' => ArrayHelper::getValue($values, 'NAME'),
                'quantity' => ArrayHelper::getValue($values, 'QUANTITY'),
                'weight' => ArrayHelper::getValue($values, 'WEIGHT'),
                'delay' => $item->isDelay(),
                'price' => ArrayHelper::getValue($values, 'PRICE'),
                'currency' => ArrayHelper::getValue($values, 'CURRENCY'),
                'canBuy' => $item->canBuy(),
                'measure' => [
                    'id' => ArrayHelper::getValue($values, 'MEASURE_CODE'),
                    'name' => ArrayHelper::getValue($values, 'MEASURE_NAME')
                ],
                'vat' => [
                    'rate' => ArrayHelper::getValue($values, 'VAT_RATE'),
                    'included' => ArrayHelper::getValue($values, 'VAT_INCLUDED') == 'Y'
                ],
                'site' => ArrayHelper::getValue($values, 'LID'),
                'url' => ArrayHelper::getValue($values, 'DETAIL_PAGE_URL')
            ];

            $array['id'] = Type::toInteger($array['id']);
            $array['quantity'] = Type::toFloat($array['quantity']);
            $array['weight'] = Type::toFloat($array['weight']);
            $array['price'] = Type::toFloat($array['price']);
            $array['measure']['id'] = Type::toInteger($array['measure']['id']);
            $array['vat']['rate'] = Type::toFloat($array['vat']['rate']);

            $result[] = $array;
        }

        return ArrayHelper::convertEncoding($result, Encoding::UTF8, Encoding::getDefault());
    }

    /**
     * Изменение количества товара в корзине.
     * @post int $id Идентификатор элемента инфоблока.
     * @post int $quantity Количество. Необязательно.
     * @return bool
     */
    public function actionSetQuantity()
    {
        $data = $this->getData();
        $id = ArrayHelper::getValue($data, 'id');
        $id = Type::toInteger($id);
        $quantity = ArrayHelper::getValue($data, 'quantity');
        $quantity = Type::toInteger($quantity);
        $quantity = $quantity < 1 ? 1 : $quantity;

        $basket = $this->getBasket();

        if ($item = $basket->getExistsItem('catalog', $id)) {
            $item->setFields(['QUANTITY' => $quantity]);
            $basket->save();
        }

        return true;
    }

    /**
     * Удаление товара из корзины.
     * @post int $id Идентификатор элемента инфоблока.
     * @return bool
     */
    public function actionRemove()
    {
        $data = $this->getData();
        $id = ArrayHelper::getValue($data, 'id');
        $id = Type::toInteger($id);

        if (empty($id))
            return false;

        $basket = $this->getBasket();

        if ($item = $basket->getExistsItem('catalog', $id)) {
            $item->delete();
            $basket->save();
        }

        return true;
    }

    /**
     * Очистка корзины.
     * @post string $basket Очищать ли корзину. (Y/N).
     * @post string $delay Очищать ли отложенные. (Y/N).
     * @return bool
     */
    public function actionClear()
    {
        $data = $this->getData();
        $basket = ArrayHelper::getValue($data, 'basket');
        $basket = $basket == 'Y';
        $delay = ArrayHelper::getValue($data, 'delay');
        $delay = $delay == 'Y';

        if (!$basket && !$delay) {
            $basket = true;
            $delay = true;
        }

        $items = $this->getBasket();

        foreach ($items as $item) {
            if (!$item->isDelay() && $basket)
                $item->delete();

            if ($item->isDelay() && $delay)
                $item->delete();
        }

        $items->save();

        return true;
    }
}