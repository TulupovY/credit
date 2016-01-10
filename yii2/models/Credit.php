<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Credit extends Model
{
    public $amount;
    public $term;
    public $rate;
    public $date_curent;
    public $month_array = array('Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'); 
    
    public function Credit()
    {

    }
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // summ, Creditterm, subject and body are required
            [['summ', 'Creditterm', 'Interestrate', 'date_curent'], 'required'],
            // email has to be a valid email address
            
            // verifyCode needs to be entered correctly
            
        ];
    }

   public function render_table($array) 
    {
            $return = '' ;
            $return .= '

            <div class="panel panel-default">
             
                  <div class="panel-heading">График платежей</div>
                  
                  <table class="table">
                 
            <thead>
            <tr>
            <th>№</th>
            <th>Дата платежа</th>
            <th>Остаток задолженности<br> по кредиту</th>
            <th>Платеж<br> по процентам</th>
            <th>Платеж<br> по кредиту</th>
            <th>Аннуитетный<br> платеж</th>
            </tr>
            </thead>
            <tbody>' ;
            foreach ($array as $key => $value) {
                $return .= '<tr>
                            <td>' . $key . '</td>
                            <td>' . $value['month'] . '</td>
                            <td>' . $value['dept'] . '</td>
                            <td>' . $value['percent_pay'] . '</td>
                            <td>' . $value['credit_pay'] . '</td>
                            <td>' . $value['payment'] . '</td>
                            </tr>';
                }
            $return .= '  </tbody>
                  </table>
                </div>' ;
            return $return;
            }



    public function credit_calculate($term, $rate, $amount, $month, $year, $round = 2)  
            {
              // $term - срок кредита (в месяцах), $rate процентная ставка, $amount - сумма кредита (в рублях)
              // $month - месяц начала выплат, $year - год начала выплат, $round - округление сумм
            global $month_array;

            $result = array();

            $term = (integer)$term;
            $rate = (float)str_replace(",", ".", $rate);
            $amount = (float)str_replace(",", ".", $amount);
            $round = (integer)$round ;

            $month_rate = ($rate/100/12) ;   //  месячная процентная ставка по кредиту (= годовая ставка / 12)
            $k = ($month_rate * pow((1 + $month_rate), $term)) / ( pow((1 + $month_rate), $term) - 1  ) ; // коэффициент аннуитета
            $payment = round($k * $amount, $round) ;   // Размер ежемесячных выплат
            $overpay = ($payment * $term) - $amount ;
            $debt = $amount ;

            for ($i = 1; $i <= $term; $i++) {

               $schedule[$i] = array()  ;

               $percent_pay = round($debt * $month_rate, $round) ;
               $credit_pay =  round($payment - $percent_pay, $round) ;

               $schedule[$i]['month'] = $month_array[$month-1] . ' ' . $year ;
               $schedule[$i]['dept'] = number_format($debt, $round, ',', ' ') ;
               $schedule[$i]['percent_pay'] = number_format($percent_pay, $round, ',', ' ') ;
               $schedule[$i]['credit_pay'] = number_format($credit_pay, $round, ',', ' ') ;
               $schedule[$i]['payment'] =  number_format($payment, $round, ',', ' ') ;

               $debt = $debt - $credit_pay ;

               if($month++ >= 12) { $month = 1; $year++ ;  }
            }

            $result['overpay'] = number_format($overpay, $round, ',', ' ') ; ;
            $result['payment'] = number_format($payment, $round, ',', ' ') ; ;
            $result['schedule'] = $this->render_table($schedule) ;

            return $result ;

            }

    /**
     * @return array customized attribute labels
     */
    

    
}