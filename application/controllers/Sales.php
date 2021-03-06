<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends Application {

	public function __construct() {
		parent::__construct();
	}
	/**
	 * Index Page for the Production controller.
	 */
	public function index()
	{
                $this->data['pagebody'] = 'sales/sales_view';
                $this->data['pagetitle'] = 'Sales Page';
		$stock = $this->stockmodel->all();

                $stockList = array();

                foreach ($stock as $item)
                {
                    $stockList[] = array (
                        'code' => $item['code'],
                        'description' => $item['description'],
                        'sellingPrice' => $item['sellingPrice'],
						'link' => str_replace(' ', '_', $item['code']),
                        'quantityOnHand' => $item['quantityOnHand']);
                }
                $this->data['stock'] = $stockList;

                $this->render();
	}

        public function showDetails($code)
        {
			$normalCode = str_replace('_', ' ', $code);
            $this->data['pagebody'] = 'sales/item_view';
            $stock = $this->stockmodel->singleStock($normalCode);
            $recipe = $this->recipesmodel->singleRecipe($normalCode);
            $this->data['pagetitle'] = $stock['code'];

            $this->data['code'] = $stock['code'];
            $this->data['description'] = $stock['description'];
            $this->data['sellingPrice'] = $stock['sellingPrice'];
            $this->data['quantityOnHand'] = $stock['quantityOnHand'];

            $ingredients = array();

            foreach ($recipe['ingredients'] as $item)
            {
                $ingredients[] = array(
                    'ingredient' => $item['ingredient'],
                    'amount' => $item['amount']);
            }
            $this->data['ingredients'] = $ingredients;

            $this->render();

        }

}
