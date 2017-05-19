<?php

namespace App\Smartmove;

use App\Smartmove\SmartmoveCodes;

use Carbon\Carbon;

class CreditReport
{
    use SmartmoveCodes;

    /**
     * @var array
     */
    protected $Status;

    /**
     * @var string
     */
    protected $FirstName;

    /**
     * @var string
     */
    protected $LastName;

    /**
     * @var string
     */
    protected $MiddleName;

    /**
     * @var string
     */
    protected $Suffix;

    /**
     * @var string
     */
    protected $BirthDate;

    /**
     * @var array
     */
    protected $Addresses;

    /**
     * @var array
     */
    protected $Akas;

    /**
     * @var array
     */
    protected $Scores;

    /**
     * @var array
     */
    protected $FraudIndicators;

    /**
     * @var array
     */
    protected $Employments;

    /**
     * @var array
     */
    protected $ConsumerStatements;

    /**
     * @var array
     */
    protected $ConsumerRightsStatements;

    /**
     * @var array
     */
    protected $Inquiries;

    /**
     * @var array
     */
    protected $PublicRecords;

    /**
     * @var array
     */
    protected $TradeLines;

    /**
     * @var array
     */
    protected $Collections;

    /**
     * @var array
     */
    protected $ProfileSummary;

    /**
     * @var array
     */
    protected $Subscribers;

    /**
     * @var string
     */
    protected $ReportRetrievedOn;

    /**
     * The raw data passed when populating this object
     * @var array
     */
    protected $attributes = [];

    /**
     * Class constructor
     *
     * @param array $data
     */
    public function __construct($data = [])
    {
    	if( empty($data) || !is_array($data) ) return;

		$data = studlyCaseArrayKeys($data);    	
    	$this->attributes = $data;

    	foreach($data as $key => $value) :
    		if( property_exists($this, $key) ) $this->$key = $value;
    	endforeach;
        
        $this->decodeAll();
    }

    public function raw()
    {
        return $this->attributes;
    }

    public function __get($property)
    {
        $allowed = [
            'Status', 'FirstName', 'LastName', 'MiddleName', 'Suffix', 'BirthDate', 'Addresses', 'Akas',
            'Scores', 'FraudIndicators', 'Employments', 'ConsumerStatements', 'ConsumerRightsStatements',
            'Inquiries', 'PublicRecords', 'TradeLines', 'Collections', 'ProfileSummary', 'Subscribers',
            'ReportRetrievedOn'
        ];

        if( in_array($property, $allowed) ) return $this->$property;

        return null;
    }

    public function has($property)
    {
        return !empty($this->$property);
    }


    /**
     * Setter for properties allowed to be set via the $allowedProperties array.
     *
     * @param string $propertyName The name of the property in the class to set
     * @param mixed|array|string|int $value The value to assigned the property
     * @return $this
     */
    /*
    public function set($propertyName, $value)
    {
        if( array_key_exists($propertyName, $this->fixCase) ) {
            $propertyName = $this->fixCase[$propertyName];
        }

        if( in_array($propertyName, $this->allowedProperties) ) {
            $customSetter = "set" . studly_case($propertyName);
            if( method_exists($this, $customSetter) ) {
                $this->$customSetter($value);
            } else if( array_key_exists($propertyName, $this->pluralToSingular) ) {
                $this->setAdvanced($propertyName, $this->pluralToSingular[$propertyName], $value);
            } else {
                $this->$propertyName = $value;
            }
        }

        return $this;
    }
    */

    /**
     * Is this credit report empty?
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->attributes);
    }

    /**
     * An advanced setter for properties that have mixed array types to bring them to a single array format.
     *
     * @param string $propertyName The name of the property in the class to set.
     * @param string $singularKey The single name of the class property
     * @param array $data The array of data to parse and set
     */
    /*
    public function setAdvanced($propertyName, $singularKey, $data)
    {
        if( array_key_exists($singularKey, $data) ) {
            if( empty($data[$singularKey]) ) {
              $this->$propertyName = $data[$singularKey];
                return;
            } else if( is_array($data[$singularKey]) && array_key_exists(0, $data[$singularKey]) ) {
                $this->$propertyName = $data[$singularKey];
                return;
            } else {
                $this->$propertyName = [$data[$singularKey]];
                return;
            }
        }

        $this->$propertyName = $data;
    }
    */


    /**
     * Decodes all the class properties sub-values that contain known keys with credit bureau codes in them.
     */
    public function decodeAll()
    {
        $toDecode = [
            'Collections', 'Addresses', 'Inquiries', 'PublicRecords', 'TradeLines', 'Akas', 'Scores', 'Employments',
            'ConsumerStatements', 'ConsumerRightsStatements', 'Subscribers', 'FraudIndicators'
        ];

        foreach( $toDecode as $propertyName ) {
        	$this->$propertyName = arrayIt($this->$propertyName);
        	$this->$propertyName = studlyCaseArrayKeys($this->$propertyName);
            $this->decode($propertyName);
        }

        $this->decodeStatus();
        $this->decodeProfileSummary();
    }

    public function decodeFraudIndicators()
    {
        if( empty($this->FraudIndicators) ) return;

        foreach( $this->FraudIndicators as $key =>  $fi) :
            if( is_string($fi) || is_numeric($fi)) :
                $this->FraudIndicators[$key] = $this->_decode($fi, 'FraudIndicatorCodes');
            else:
                unset($this->FraudIndicators[$key]);
            endif;
        endforeach;
    }

    /**
     * Perform the assigned decode function for a property.
     *
     * @param $propertyName
     * @return mixed
     */
    public function decode($propertyName)
    {    	
        $function = "decode" . studly_case($propertyName);
        if( method_exists($this, $function) ) {
        	return $this->$function();
        }        
    }

    /**
     * [decodeProfileSummary description]
     * @return [type] [description]
     */
    public function decodeProfileSummary()
    {
        $shouldExist = [
            'ClosedWithBal', 'DerogItems', 'Inquiry', 'InstallBalance', 'Installment', 'MonthlyPayment', 'Mortgage', 'NumberOfInquiries',
            'Open', 'PastDueAmount', 'PastDueItems', 'PublicRecordCount', 'RealEstateBalance', 'RealEstatePayment', 'Revolving', 
            'RevolveAvailPercent', 'RevolveBalance', 'Total', 'TradeLine',
        ];
        $existDictionary = [
            'ClosedWithBal' =>  ['Count', 'HighCredit', 'CreditLimit', 'Balance', 'MonthlyPayment', 'PercentCreditAvail'],
            'DerogItems' =>  ['PublicRecordCount', 'CollectionCount', 'NegTradelineCount', 'HistNegTradelineCount', 'OccuranceHistCount'],
            'Inquiry' =>  ['Count', 'Last6MonthsCount'],
            'Installment' =>  ['Count', 'HighCredit', 'CreditLimit', 'Balance', 'MonthlyPayment', 'PercentCreditAvail'],
            'Mortgage' =>  ['Count', 'HighCredit', 'CreditLimit', 'Balance', 'MonthlyPayment', 'PercentCreditAvail'],
            'Open' =>  ['Count', 'HighCredit', 'CreditLimit', 'Balance', 'MonthlyPayment', 'PercentCreditAvail'],
            'PastDueItems' =>  ['RevolvingPastDue', 'InstallmentPastDue', 'MortgagePastDue', 'OpenPastDue', 'ClosedWithBalPastDue', 'TotalPastDue'],
            'Revolving' =>  ['Count', 'HighCredit', 'CreditLimit', 'Balance', 'MonthlyPayment', 'PercentCreditAvail'],
            'Total' =>  ['Count', 'HighCredit', 'CreditLimit', 'Balance', 'MonthlyPayment', 'PercentCreditAvail'],
            'TradeLine' =>  ['Count', 'PaidCount', 'SatisfactoryCount', 'NowDerogCount', 'WasDerogCount', 'OldestDate', 'ThirtyDayCount', 'SixtyDayCount', 'NinetyDayCount'],
        ];

        // First we'll find any missing primary keys
        foreach( $this->_missing($shouldExist, $this->ProfileSummary) as $key) :
            if( array_key_exists($key, $existDictionary) )
                $this->ProfileSummary[$key] = [];
            else 
                $this->ProfileSummary[$key] = null;
        endforeach;

        // Now we'll go through each existDictionary to insure each of the keys have the 
        // matching properties
        foreach( $existDictionary as $key => $val ) :
            foreach( $this->_missing($val, $this->ProfileSummary[$key] ) as $property ) :
                $this->ProfileSummary[$key][$property] = null;
            endforeach;
        endforeach;
    }

    public function decodeSubscribers()
    {
        if( empty($this->Subscribers)) return false;

        $shouldExist = ['Id', 'Name', 'Phone', 'StreetAddress', 'City', 'State', 'PostalCode'];

        foreach($this->Subscribers as $key => $value) :
            foreach($this->_missing($shouldExist, $value) as $property) :
                $this->Subscribers[$key][$property] = null;
            endforeach;
        endforeach;
    }

    /**
     * Decode the Status
     * @return [type] [description]
     */
    public function decodeStatus()
    {
        if( empty($this->Status)) return;

        $shouldExist = ['ReportDate', 'FrozenFile', 'ThinFile', 'RecordFound', 'AddressDiscrepancyIndicator', 'BureauErrorMessage'];

        foreach($this->_missing($shouldExist, $this->Status) as $key) :
            $this->Status[$key] = false;
        endforeach;
    }

    /**
     * Decode the Employments Object
     */
    public function decodeEmployments()
    {
        if( empty($this->Employments)) return false;

        $shouldExist = ['City', 'DateEmployed', 'DateVerified', 'EmployerName', 'State'];

        foreach( $this->Employments as $key => $value ) :
            foreach($this->_missing($shouldExist, $value) as $property) :
                $this->Employments[$key][$property] = null;
            endforeach;
        endforeach;
    }

    /**
     * Decode the "Scores" Object
     */
    public function decodeScores()
    {
    	if(array_key_exists(0, $this->Scores) )
    		$this->Scores = $this->Scores[0];

    	$shouldExist = ['Score', 'ScoreFactor1', 'ScoreFactor2', 'ScoreFactor3', 'ScoreFactor4', 'RejectMessageCode', 'DerogAletCode'];

    	foreach($this->_missing($shouldExist, $this->Scores) as $property) {
    		$this->Scores[$property] = null;
    	}

    	if( array_key_exists('ScoreFactor1', $this->Scores) ) 
    		$this->Scores['ScoreFactor1'] = $this->_decode(numbersOnly($this->Scores['ScoreFactor1']), 'ScoreFactorCodes');
    	
    	if( array_key_exists('ScoreFactor2', $this->Scores) ) 
    		$this->Scores['ScoreFactor2'] = $this->_decode(numbersOnly($this->Scores['ScoreFactor2']), 'ScoreFactorCodes');

    	if( array_key_exists('ScoreFactor3', $this->Scores) ) 
    		$this->Scores['ScoreFactor3'] = $this->_decode(numbersOnly($this->Scores['ScoreFactor3']), 'ScoreFactorCodes');

    	if( array_key_exists('ScoreFactor4', $this->Scores) ) 
    		$this->Scores['ScoreFactor4'] = $this->_decode(numbersOnly($this->Scores['ScoreFactor4']), 'ScoreFactorCodes');

    	if( array_key_exists('RejectMessageCode', $this->Scores) ) 
    		$this->Scores['RejectMessageCode'] = $this->_decode($this->Scores['RejectMessageCode'], 'ScoreFactorCodes');

    	if( array_key_exists('DerogAlertCode', $this->Scores) ) 
    		$this->Scores['DerogAlertCode'] = $this->_decode($this->Scores['DerogAlertCode'], 'ScoreFactorCodes');
    }

    /**
     * Decode the Address property
     */
    public function decodeAddresses()
    {

        if( empty($this->Addresses)) return;        

        $shouldExist = ['AddressQualifier', 'City', 'DateReported', 'PostalCode', 'SourceIndicator', 'State', 'StreetAddress'];
        
        $codes = ['SourceIndicator', 'AddressQualifier'];
        
        foreach( $this->Addresses as $key => $address ) {
        	// Find any missing attributs so we can set null values for them
        	foreach($this->_missing($shouldExist, $address) as $property) {
        		$this->Addresses[$key][$property] = null;
        	}
        	
        	
        	// Now replace codes with lamen terms if needed        	
    		$this->Addresses[$key]['SourceIndicator'] = $this->_decode($address['SourceIndicator'], 'SourceIndicator');
    		$this->Addresses[$key]['AddressQualifier'] = $this->_decode($address['AddressQualifier'], 'AddressQualifier');
        }
    }

    /**
     * Decode the AKA array to insure all information is correct
     */
    public function decodeAkas()
    {
    	if( empty($this->Akas) ) return;

    	$shouldExist = ['FirstName', 'MiddleName', 'LastName', 'Suffix'];
    	foreach($this->Akas as $key => $value) {
    		
    		foreach($this->_missing($shouldExist, $value) as $property) {
    			$this->Akas[$key][$property] = null;
    		}
    	}
    }

    /**
     * Decode the Inquiries property
     */
    public function decodeInquiries()
    {
        if( empty($this->Inquiries) ) return;

        $shouldExist = ['IndustryCode', 'SubsciberId', 'SubscriberName', 'InquiryDate'];

        foreach( $this->Inquiries as $key =>  $value ) {      

            if( array_key_exists('IndustryCode', $value) ) {
                $this->Inquiries[$key]['IndustryCode'] = $this->_decode($value['IndustryCode'], 'IndustryCodes');
            }

            foreach($this->_missing($shouldExist, $value) as $property ) {
                $this->Inquiries[$key][$property] = null;
            }
        }
    }

    /**
     * Decode the publicRecords property
     */
    public function decodePublicRecords()
    {
        if( empty($this->PublicRecords) ) return;

        $shouldExist = [
            'AccountDesignator', 'AssetAmount', 'CourtCode', 'CourtLocationCity', 'CourtLocationState', 'DateReported', 'DateSettled', 'IndustryCode',
            'LegalDesignator', 'LiabilitiesAmount', 'MemberCode', 'Plaintiff', 'CourtType', 'PublicRecordType', 'ReferenceNumber',
        ];

        foreach( $this->PublicRecords as $key => $value ) :

            if( array_key_exists('AccountDesignator', $value) )
                $this->PublicRecords[$key]['AccountDesignator'] = $this->_decode($value['AccountDesignator'], 'AccountDesignatorCodes');
            
            if( array_key_exists('IndustryCode', $value) )
                $this->PublicRecords[$key]['IndustryCode'] = $this->_decode($value['IndustryCode'], 'IndustryCodes');

            if( array_key_exists('CourtType', $value) )
                $this->PublicRecords[$key]['CourtType'] = $this->_decode($value['CourtType'], 'CourtTypeCodes');

            if( array_key_exists('PublicRecordType', $value) )
                $this->PublicRecords[$key]['PublicRecordType'] = $this->_decode($value['PublicRecordType'], 'PublicRecordTypeCodes');

            foreach( $this->_missing($shouldExist, $value) as $property) :
                $this->PublicRecords[$key][$property] = null;
            endforeach;
        endforeach;

        
    }

    /**
     * Decode the TradeLines property
     */
    public function decodeTradeLines()
    {
        if( empty($this->TradeLines) ) return;

        $shouldExist = [
            'SubscriberId', 'SubscriberName', 'NarrativeCode1', 'NarrativeCode2', 'NarrativeCode3',
            'NarrativeCode4', 'DateReported', 'Terms', 'TermsAmountOfPayment', 'AccountType',
            'IndustryCode', 'AccountDesignator', 'DateVerified', 'DateOpened', 'DateClosedIndicator', 
            'DateClosed', 'DatePaidOut', 'VerificationIndicator', 'CurrentMOP', 'MaximumDelinqMOP',
            'MaximumDelinqDate', 'HighCredit', 'CreditLimit', 'TermsFrequencyOfPayment', 'LoanType',
            'AmountPastDue', 'BalanceAmount', 'PaymentPattern', 'PaymentPatternStartDate', 'Times30DaysLate',
            'Times60DaysLate', 'Times90DaysLate', 'RemarksCode'
        ];

        foreach( $this->TradeLines as $key => $value ) :
            if( empty($value) ) continue;
            // First fix all the codes.
            if( array_key_exists('AccountType', $value) )
                $this->TradeLines[$key]['AccountType'] = $this->_decode($value['AccountType'], 'AccountTypeCodes');

            if( array_key_exists('IndustryCode', $value) )
                $this->TradeLines[$key]['IndustryCode'] = $this->_decode($value['IndustryCode'], 'IndustryCodes');

            if( array_key_exists('AccountDesignator', $value) )
                $this->TradeLines[$key]['AccountDesignator'] = $this->_decode($value['AccountDesignator'], 'AccountDesignatorCodes');

            if( array_key_exists('DateClosedIndicator', $value) ) 
                $this->TradeLines[$key]['DateClosedIndicator'] = $this->_decode($value['DateClosedIndicator'], 'DateClosedIndicatorCodes');
            
            if( array_key_exists('CurrentMOP', $value) ) 
                $this->TradeLines[$key]['CurrentMOP'] = $this->_decode($value['CurrentMOP'], 'AccountRatingCodes');

            if( array_key_exists('MaximumDelinqMOP', $value) )
                $this->TradeLines[$key]['MaximumDelinqMOP'] = $this->_decode($value['MaximumDelinqMOP'], 'AccountRatingCodes');

            if( array_key_exists('TermsFrequencyOfPayment', $value) )
                $this->TradeLines[$key]['TermsFrequencyOfPayment'] = $this->_decode($value['TermsFrequencyOfPayment'], 'TermsFrequencyOfPaymentCodes');

            if( array_key_exists('LoanType', $value) ) 
                $this->TradeLines[$key]['LoanType'] = $this->_decode($value['LoanType'], 'LoanTypeCodes');

            if( array_key_exists('PaymentPattern', $value) && array_key_exists('PaymentPatternStartDate', $value))
                $this->TradeLines[$key]['PaymentPattern'] = $this->decodePaymentPattern($value['PaymentPattern'], $value['PaymentPatternStartDate']);

            if( array_key_exists('RemarksCode', $value) ) 
                $this->TradeLines[$key]['RemarksCode'] = $this->_decode($value['RemarksCode'], 'RemarksCodes');


            // Now insure all items are present
            foreach( $this->_missing($shouldExist, $value) as $property ) :
                $this->TradeLines[$key][$property] = null;
            endforeach;
        endforeach;
        
    }

    /**
     * Decode a provided payment pattern
     */
    public function decodePaymentPattern($pattern = '', $startDate)
    {
        if(empty($pattern) ) return [];

        $date = Carbon::createFromFormat('Y-m-d\TH:i:s', $startDate);

        $pattern = str_split($pattern);
        $output = [];

        foreach($pattern as $payment) {
            $output[] = [
                'date' => $date->format('Y-m-d'),
                'payment' => $this->_decode($payment, 'PaymentPatternLogic'),
            ];
           $date =  $date->subMonths(1);
        }
        return $output;
    }

    /**
     * Decode the collections property
     */
    public function decodeCollections()
    {
        if( empty($this->Collections) ) return;

        $shouldExist = [
        	'AccountType', 'CustomerNumber', 'CollectionAgencyName', 'CreditorsName', 'IndustryCode', 'AccountDesignator',
        	'DateVerified', 'DateOpened', 'DateClosedIndicator', 'DateClosed', 'DatePaidOut', 'DateReported', 
        	'VerificationIndicator', 'CurrentMOP', 'CurrentBalance', 'RemarksCode', 'HighCredit'
        ];

        $codes = ['AccountType', 'IndustryCode', 'AccountDesignator', 'VerificationIndicator', 'RemarksCode', 'DateClosedIndicator'];


        
        foreach( $this->Collections as $key => $collection ) :
                foreach($this->_missing($shouldExist, $collection) as $value) :
                    $this->Collections[$key][$value] = null;
                endforeach;

                if( array_key_exists('AccountType', $collection) )
                $this->Collections[$key]['AccountType'] = $this->_decode($collection['AccountType'], 'AccountTypeCodes');

            if( array_key_exists('IndustryCode', $collection) )
                $this->Collections[$key]['IndustryCode'] = $this->_decode($collection['IndustryCode'], 'IndustryCodes');

            if( array_key_exists('AccountDesignator', $collection) )
                $this->Collections[$key]['AccountDesignator'] = $this->_decode($collection['AccountDesignator'], 'AccountDesignatorCodes');

            if( array_key_exists('CurrentMOP', $collection) )
                $this->Collections[$key]['CurrentMOP'] = $this->_decode($collection['CurrentMOP'], 'AccountRatingCodes');

            if( array_key_exists('RemarksCode', $collection) )
                $this->Collections[$key]['RemarksCode'] = $this->_decode($collection['RemarksCode'], 'RemarksCode');

        endforeach;
    }

    /**
     * Decode the Consumer Statements Object
     */
    public function decodeConsumerStatements()
    {
        if( empty($this->ConsumerStatements)) return;

        $shouldExist = ['StatementText', 'TypeCode'];

        foreach($this->ConsumerStatements as $key => $value ) {
            foreach($this->_missing($shouldExist, $value) as $property ) {
                $this->ConsumerStatements[$key][$property] = null;
            }
        }
    }

     /**
     * Decode the Consumer Rights Statements Object
     */
    public function decodeConsumerRightsStatements()
    {
        if( empty($this->ConsumerRightsStatements)) return;

        $shouldExist = ['ContentType', 'Statement'];

        foreach($this->ConsumerRightsStatements as $key => $value ) {
            foreach($this->_missing($shouldExist, $value) as $property ) {
                $this->ConsumerRightsStatements[$key][$property] = null;
            }
        }
    }

    /**
     * Does this credit report have a positive integer score?
     *
     * @return bool
     */
    public function hasScore()
    {
        if( array_key_exists('score', $this->scores) ) {
            if(is_numeric($this->scores['score']) && $this->scores['score'] > 0) {
                return true;
            }
        }

        return false;
    }

    public function score()
    {
        return array_key_exists('score', $this->scores) ? $this->scores['score'] : 0;
    }

    public function smartmoveFormat()
    {
        return $this->attributes;
    }

    public function fullName()
    {
        $name = $this->firstName . ' ';

        if( !empty($this->middleName)) $name.= $this->middleName . ' ';

        $name.= $this->lastName;

        return $name;
    }

    public function scoreFactors()
    {
        $factorNames = ['scoreFactor1', 'scoreFactor2', 'scoreFactor3', 'scoreFactor4'];

        $factors = [];
        foreach( $factorNames as $factor ) {
            if( array_key_exists($factor, $this->scores) && !empty($this->scores[$factor]) ) {
                $factors[] = $this->scores[$factor];
            }
        }

        if( !empty($factors) ) {
            return $factors;
        }

        return false;
    }

    public function profileSummaryItem($item)
    {
        return $this->get('profileSummary')[$item];
    }

    public function reportDate()
    {
        if( is_array($this->status) && array_key_exists('reportDate', $this->status) ) {
            return $this->status['reportDate'];
        }

        return null;
    }

}