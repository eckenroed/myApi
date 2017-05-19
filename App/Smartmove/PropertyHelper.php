<?php

namespace App\Smartmove;

/**
 * This trait will add some extra functionality to the Smartmove Property model 
 * to help it better communicate with TransUnion Servers. 
 */
trait PropertyHelper {

	/**
	 * The template for questions and answers that TransUnion Uses
	 * @var array
	 */
	protected $SMQuestions = [
        [
            "QuestionId"    => 1,
            "QuestionText"  => "How would you describe your property?",
            "Options"       => [
                [
                    "AnswerText"        => "A",
                    "AnswerDescription" => "High end property offering many amenities and convenience to renters (for example on-site fitness facility with modern, maintained equipment or easy access to the same, laundry facilities within the unit or within the immediate building, etc.).  If the property is new, it employs higher-end equipment, appliances and convenience features throughout the facility and/or unit(s).  If the property is aged, it has been significantly renovated recently to modernize key areas within the property (for example parking areas, parking garages or overhangs, gated community, etc.) and key features (for example appliances, furnishing, cabinets, bathroom fixtures, etc.).  'A' properties will have a lower risk factor, requiring higher standards of renters in regards to income and credit history.",
                ],
                [
                    "AnswerText"        => "B",
                    "AnswerDescription" => "Moderate living property offering some key amenities and/or conveniences to renters (for example laundry facilities within the building or in a facility very near by, easily accessible, though not on-site, fitness facility with modern equipment, etc.).  If the property has been recently built, the quality of materials used for common features of the property and/or unit(s) is good, though not high-end.  For somewhat aged properties, significant renovations have been applied to improve common-use features (for example water heaters, appliances, bathroom fixtures, paint, etc.).  'B' properties employ a moderate risk factor that will eliminate applicants with poor credit histories while still accepting moderate to good credit histories and income.",
                ],
                [
                    "AnswerText"        => "C",
                    "AnswerDescription" => "Low-end property offering few, if any, amenities or conveniences to renters (for example laundry facilities, fitness facility, etc.).  If the property has been recently built, the quality of materials used for common features of the property and/or unit(s) is average or bulk building supplies.  For somewhat aged properties, few, if any, renovations have been applied to update common-use features (for example water heaters, appliances, bathroom fixtures, paint, etc.).  'C' properties employ a high risk factor reflecting a lower quality offering to potential renters and allowing lower standards for potential lessees.",
                ],
            ],
        ],
        [
            "QuestionId"    => 2,
            "QuestionText"  => "How does your unit(s)'s rent compare to others in the neighborhood?",
            "Options"       => [
                [
                    "AnswerText"        => "A",
                    "AnswerDescription" => "Average applicant income will be significantly higher than expected rent",
                ],
                [
                    "AnswerText"        => "B",
                    "AnswerDescription" => "Average applicant income will be somewhat higher than expected rent",
                ],
                [
                    "AnswerText"        => "C",
                    "AnswerDescription" => "Average applicant income will be just above the expected rent",
                ],
            ],
        ],
        [
            "QuestionId"    => 3,
            "QuestionText"  => "What do you expect the average income of your potential applicants to be?",
            "Options"       => [
                [
                    "AnswerText"        => "A",
                    "AnswerDescription" => "Average applicant income will be much greater than the average income for the area",
                ],
                [
                    "AnswerText"        => "B",
                    "AnswerDescription" => "Average applicant income will be at the average income for the area",
                ],
                [
                    "AnswerText"        => "C",
                    "AnswerDescription" => "Average applicant income will be below the average income for the area",
                ],
            ],
        ],
        [
            "QuestionId"    => 4,
            "QuestionText"  => "Do you expect the average income of your potential applicants to be above, at, or below the average income of other tenants in the neighborhood?",
            "Options"       => [
                [
                    "AnswerText"        => "A",
                    "AnswerDescription" => "Expected rent will be greater than the average rent for the area",
                ],
                [
                    "AnswerText"        => "B",
                    "AnswerDescription" => "Expected rent will be at the average rent for the area",
                ],
                [
                    "AnswerText"        => "C",
                    "AnswerDescription" => "Expected rent will be below the average rent for the area",
                ],
            ],
        ],
        [
            "QuestionId"    => 5,
            "QuestionText"  => "Do you expect many applicants to apply for your unit(s)?",
            "Options"       => [
                [
                    "AnswerText"        => "A",
                    "AnswerDescription" => "Expect many applicants and good visibility for these units",
                ],
                [
                    "AnswerText"        => "B",
                    "AnswerDescription" => "Expect a steady number of applicants with average visibility for these unit(s)",
                ],
                [
                    "AnswerText"        => "C",
                    "AnswerDescription" => "Expect few applicants",
                ],
            ],
        ],
    ];

    /**
     * Spins through the answers array and sets them as the 
     * answers to the Questions. 
     * 
     * @return void 
     */
    protected function _populateAnswersToQuestions()
    {
        if( empty( $this->answers ) ) return;

        $question = 1;
        foreach( $this->answers as $answer ) :
            $this->_setAnswer($question, $answer);
            $question++;
        endforeach;
    }

    /**
     * Assign the answer to the question
     * 
     * @param int $questionId 
     * @param int $answer
     */
    protected function _setAnswer($questionId, $answer)
    {
        foreach( $this->SMQuestions as $index => $question ) :
            if( $question['QuestionId'] == $questionId ) :
                $this->SMQuestions[$index]['SelectedAnswer'] = $answer;
                break;                
            endif;
        endforeach;
    }

    /**
     * Returns an array that can be used in a "POST" to smartmove
     * 
     * @return array
     */
    public function formatForSmartmove()
    {
        
    	// Make sure the Questions array is up to date
    	$this->_populateAnswersToQuestions();
        
    	return [
    		'PropertyId' => (int)$this->smartmove_property_id,
    		//'PropertyIdentifier' => '',
    		'OrganizationName' => $this->landlord->smartmove_organization_name ? $this->landlord->smartmove_organization_name : '',
    		'OrganizationId' => (int)$this->landlord->smartmove_id,
    		'Active' => $this->active,
    		'Name' => $this->name,
    		'Street' => $this->street,
    		'City' => $this->city,
    		'State' => $this->state,
    		'Zip' => $this->zip,
    		'Phone' => $this->landlord->primaryPhone()->number,
    		'PhoneExtension' => '',
    		'UnitNumber' => '',
    		'Questions' => $this->SMQuestions,
    		'Classification' => $this->classification,
    		'IR' => $this->ir,
    		'IncludeMedicalCollections' => $this->include_medical_collections,
    		'IncludeForeclosures' => $this->include_foreclosures,
    		'OpenBankruptcyWindow' => $this->open_bankruptcy_window,
    		'IsFcraAgreementAccepted' => $this->is_fcra_agreement_accepted,
    		'DeclineForOpenBankruptcies' => $this->decline_for_open_bankruptcies,
    		'Landlord' => $this->landlord->formatForSmartmove()
    	];
    }

}
