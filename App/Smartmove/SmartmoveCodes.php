<?php

namespace App\Smartmove;


/**
 * Class SmartmoveCodes
 * @package App\TenantScreening
 */
trait SmartmoveCodes
{

    /**
     * Account Designator Codes for Trade lines on Credit Report
     * @var array
     */
    protected $AccountDesignatorCodes = [
        'A' =>  'Authorized user on account',
        'C' =>  'Joint contractual liability on account',
        'I' => 'Individual account',
        'M' =>  'Primary borrower on account',
        'P' =>  'Participant on account',
        'S' =>  'Co-signer on account',
        'T' =>  'Account relationship terminated',
        'U' => 'Undesignated account',
        'X' => 'Consumer deceased',
    ];

    /**
     * Account Rating codes for Trade Line Accounts on Credit Report
     * @var array
     */
    protected $AccountRatingCodes = [
        '00' => 'No rating',
        '01' => 'Paid or paying as agreed',
        '02' => '30 days past due',
        '03' => '60 days past due',
        '04' => '90 days past due',
        '05' => '120 days past due',
        '07' => 'Wage earner or similar plan',
        '08' => 'Repossession',
        '8A' => 'Voluntary surrender',
        '8D' => 'Legal repossession',
        '8P' => 'Payment after repossession',
        '8R' => 'Repossession redeemed',
        '09' => 'Charged off as bad debt',
        '9B' => 'Collection account',
        '9P' => 'Payment after charge off/collection',
        'SL' => 'Slow pay',
        'UC' => 'Unclassified',
        'UR' => 'Unrated or bankruptcy',
    ];

    /**
     * Account Type codes for Credit Report and public records
     * @var array
     */
    protected $AccountTypeCodes = [
        'I' => 'Installment',
        'C' => 'Credit / Line of Credit',
        'M' => 'Mortgage',
        'O' => 'Open',        
        'R' => 'Revolving',
    ];

    /**
     * Court types as seen on the criminal report
     * @var array
     */
    protected $CourtTypeCodes = [
        'AS' =>  'Associate Court',
        'BK' =>  'U.S. Bankruptcy Court',
        'CA' =>  'County Auditor',
        'CC' =>  'County Clerk',
        'CH' =>  'Chancery Court',
        'CI' =>  'Circuit Court',
        'CL' =>  'County Court at Law',
        'CN' =>  'Conciliation Court',
        'CO' =>  'Common Claims',
        'CP' =>  'Common Pleas',
        'CR' =>  'County Recorder CT County Court',
        'CT' => 'County Court',
        'CY' =>  'City Court',
        'DC' =>  'District Count',
        'DO' =>  'Domestic Court',
        'DS' =>  'District Judge System FE Federal District',
        'FE' => 'Federal District',
        'GS' =>  'General Sessions',
        'IC' =>  'Inferior Court',
        'JU' =>  'Justice of the Peace',
        'MA' =>  'Magistrate Court MU Municipal Court',
        'M1' =>  'Magisterial Court, Type 1',
        'M2' =>  'Magisterial Court, Type 2',
        'M3' =>  'Magisterial Court, Type 3',
        'M4' =>  'Magisterial Court, Type 4',
        'MU' => 'Municipal Court',
        'PC' =>  'Parish Court',
        'PR' =>  'Probate Court',
        'RD' =>  'Recorder of Deeds',
        'SC' =>  'Small Claims',
        'ST' =>  'State Court',
        'SU' =>  'Superior Court',
    ];

    /**
     * Fraud Indicator codes as used on the Credit Report
     * @var array
     */
    protected $FraudIndicatorCodes = [
        '0001' => 'Address submitted is a mail receiving service.',
        '0002' => 'Address submitted is a hotel/motel or a temporary residence.',
        '0003' => 'Address submitted is a non-residential address.',
        '0005' => 'Address submitted is a non-residential address.',
        '0007' => 'Address submitted is a non-residential address.',
        '0009' => 'Address submitted is a non-residential address.',
        '0010' => 'Address submitted is a non-residential address.',
        '0500' => 'Address submitted is a non-residential address.',
        '0501' => 'Address submitted is a non-residential address.',
        '0502' => 'Address submitted is a non-residential address.',
        '0503' => 'Address submitted is a non-residential address.',
        '1000' => 'Address submitted is a non-residential address.',
        '1500' => 'Address submitted is a non-residential address.',
        '0004' => 'Address submitted is a camp site.',
        '0006' => 'Address submitted is a check-cashing facility.',
        '0008' => 'Address submitted is a storage facility.',
        '1001' => 'Address submitted is a U.S. Post Office street address.',
        '1501' => 'Address submitted has been reported as suspicious.',
        '1502' => 'Address submitted has been reported as suspicious.',
        '3000' => 'Address submitted has been reported as suspicious.',
        '1503' => 'Applicant\'s prior address has been associated with fraudulent activity',
        '1504' => 'Applicant\'s prior address has been associated with fraudulent activity',
        '2001' => 'Applicant\'s prior address has been associated with fraudulent activity',
        '2501' => 'Address submitted has been used more than once within the last 90 days on different inquiries',
        '2502' => 'Address submitted has been reported more than once.',
        '2999' => 'Address submitted is a multi-unit building.',
        '3001' => 'This name and SSN have been reported as being associated with fraudulent use.',
        '3003' => 'This name and SSN have been reported as being associated with fraudulent use.',
        '3501' => 'This name and SSN have been reported as being associated with fraudulent use.',
        '4001' => 'There is a possibility of fraud - the SSN submitted is associated with a person reported as deceased.',
        '4501' => 'SSN may be invalid - it was either very recently or never issued by the Social Security Administration.',
        '4502' => 'Name and SSN have been reported as being associated with fraudulent use.',
        '5501' => 'SSN have been used more than once with the last 90 days on different inquiries',
        '5503' => 'SSN has been issued by the Social Security Administration within the past five years.',
        '5999' => 'Input/file SSN requires further investigation',
        '9001' => 'Input addresses (es), SSN and/or telephone number reported together in suspected misuse.',
        '9002' => 'Input/file addresses, SSN, or telephone number reported by more than one source.',
        '9003' => 'Consumer statement on file relates to true name fraud or credit fraud.',
        '9004' => 'Active military duty alert on file.',
        '9005' => 'Initial fraud alert on file.',
        '9006' => 'Extended fraud victim alert on file.',
        'C11' => 'Current address mismatch - input does not match file.',
        'P11' => 'Previous address mismatch - input does not match file',
    ];

    /**
     * Industry Codes as seen on Credit Report
     * @var array
     */
    protected $IndustryCodes = [
        'A' =>  'Automotive',
        'B' =>  'Banks',
        'C' =>  'Clothing',
        'D' =>  'Department stores',
        'E' =>  'Employment',
        'F' =>  'Finance, personal',
        'G' =>  'Groceries',
        'H' =>  'Home furnishing',
        'I' =>  'Insurance',
        'J' =>  'Jewelry, cameras, computers',
        'K' =>  'Contractors',
        'L' =>  'Building materials',
        'M' =>  'Medical and related health',
        'N' =>  'Credit card, travel/entertainment',
        'O' =>  'Oil companies',
        'P' =>  'Personal services other than medical',
        'Q' =>  'Finance other than personal',
        'R' => 'Real estate, public accommodations',
        'S' => 'Sporting goods',
        'T' => 'Farm/garden supplies',
        'U' => 'Utilities and fuel',
        'V' => 'Government',
        'W' => 'Wholesale',
        'X' => 'Advertising',
        'Y' => 'Collection services',
        'Z' => 'Miscellaneous',
    ];

    /**
     * Loan Type codes as used on Trade Lines on Credit Report
     * @var array
     */
    protected $LoanTypeCodes = [
        'AF' => 'Appliance/Furniture',
        'AG' => 'Collection Agency/Attorney',
        'AL' => 'Auto Lease',
        'AP' => 'Airplane',
        'AR' => 'Auto Loan—Refinanced',
        'AT' => 'Auto Loan—Equity Transfer',
        'AU' => 'Automobile',
        'AX' => 'Agricultural Loan',
        'BC' => 'Business Credit Card',
        'BL' => 'Revolving Business Lines',
        'BT' => 'Boat',
        'BU' => 'Business',
        'CA' => 'Camper',
        'CB' => 'Combined Credit Plan',
        'CC' => 'Credit Card',
        'CE' => 'Commercial Line of Credit',
        'CG' => 'Commercial Credit Obligation',
        'CH' => 'Charge Account',
        'CI' => 'Commercial Installment Loan',
        'CO' => 'Consolidation',
        'CP' => 'Child Support',
        'CR' => 'Cond. Sales Contract; Refinance',
        'CS' => 'Conditional Sales Contract',
        'CU' => 'Telecommunications/Cellular',
        'CV' => 'Conventional Real Estate Mortgage',
        'CW' => 'Credit Watch',
        'CY' => 'Commercial Mortgage DC Debit Card',
        'DR' => 'Deposit Related',
        'DS' => 'Debt Counseling Service',
        'EM' => 'Employment',
        'FC' => 'Factoring Company Account',
        'FD' => 'Fraud Identify Check',
        'FE' => 'Attorney Fees',
        'FH' => 'FHA Loan',
        'FI' => 'FHA Home Improvement',
        'FL' => 'FMHA Real Estate Mortgage',
        'FM' => 'Family Support',
        'FR' => 'FHA Real Estate Mortgage',
        'FT' => 'Collection Credit Report Inquiry FX Flexible Spending Credit Card GA Government Employee Advance',
        'GE' => 'Government Fee for Services',
        'GF' => 'Government Fines',
        'GG' => 'Government Grant',
        'GH' => 'Fraud Check Req. & Govt Rpt',
        'GO' => 'Government Overpayment GS Government Secured',
        'GU' => 'Govt. Unsecured Guar/Dir Ln',
        'HE' => 'Home Equity Loan HG Household Goods',
        'HI' => 'Home Improvement',
        'HK' => 'High Risk Fraud Match Received IE ID Report for Employment',
        'IS' => 'Installment Sales Contract',
        'LC' => 'Line of Credi',
        'LE' => 'Lease',
        'LI' => 'Lender-placed Insurance LN Construction Loan',
        'LS' => 'Credit Line Secured',
        'MB' => 'Manufactured Housing',
        'MD' => 'Medical Debt',
        'MH' => 'Medical/Health Care MT Motor Home',
        'NT' => 'Note Loan',
        'PS' => 'Partly Secured',
        'RA' => 'Rental Agreement',
        'RC' => 'Returned Check',
        'RD' => 'Recreational Merchandise',
        'RE' => 'Real Estate',
        'RL' => 'Real Estate—Junior Liens',
        'RM' => 'Real Estate Mortgage',
        'RV' => 'Recreational Vehicle',
        'SA' => 'Summary of Accounts—Same Status SC Secured Credit Card',
        'SE' => 'Secured',
        'SF' => 'Secondary Use of a Credit Report for Auto Financing',
        'SH' => 'Secured by Household Goods',
        'SI' => 'Secured Home Improvement',
        'SK' => 'Skip',
        'SM' => 'Second Mortgage',
        'SO' => 'Secured by Household Goods & Collateral',
        'SR' => 'Secondary Use of a Credit Report',
        'ST' => 'Student Loan',
        'SU' => 'Spouse Support',
        'SX' => 'Secondary Use of a Credit Report for Other Financing',
        'TC' => 'SSN Search/ID Search Inquiry',
        'TS' => 'Time Shared Loan UC Utility Company UK Unknown',
        'US' => 'Unsecured',
        'VA' => 'V.A. Loan',
        'VM' => 'V.A. Real Estate Mortgage',
        'WT' => 'Individual Monitoring Report Inquiry',
    ];

    protected $PersonGenderCodes = [
        'M'   => 'Male',
        'F' => 'Female',
        'U' => 'Unclassified'
    ];

    protected $CourtDispositionCodes = [
        'ADMF'      => 'Admitted to a Finding',
        'ASF'       => 'Admitted to a Finding',
        'APP'       => 'Appeal',
        'APP WD'    => 'Appeal Withdrawn',
        'B'         => 'Bail',
        'BF'        => 'Brought Forward',
        'BO'        => 'Bond Over',
        'BOGJ'      => 'Bound Over',
        'BOF'       => 'Balance of Fine',
        'C'         => 'Continued',
        'CASP'      => 'Community Alcohol Safety Program',
        'CBF'       => 'Case Brought Forward',
        'CC'        => 'Court Costs',
        'CCI'       => 'Court Costs Included',
        'CMNTY SRV' => 'Community Service',
        'CMTD'      => 'Committed, Incarcerated',
        'COM'       => 'Committed, Incarcerated',
        'CMUT'      => 'Commuted',
        'CWOF'      => 'Continued without a Finding',
        'CWF'       => 'Continued without a Finding',
        'DISCH'     => 'Discharged',
        'DISM'      => 'Dismissed',
        'DRC'       => 'Dismissed',
        'DRD'       => 'Dismissed',
        'DWOP'      => 'Dismissed without Prejudice',
        'EXTN'      => 'Extended',
        'FILE'      => 'Placed on File',
        'NF'        => 'No Finding',
        'FILE NF'   => 'No Finding',
        'FINE'      => 'Fined',
        'G'         => 'Convicted',
        'GJ'        => 'Grand Jury',
        'HWB'       => 'Held Without Bail',
        'IND'       => 'Indicted',
        'INDICT'    => 'Indicted',
        'JT'        => 'Jury Trial',
        'LIFE'      => 'Life Sentence',
        'MT'        => 'Mistrial',
        'MIS'       => 'Mistrial',
        'NF'        => 'No Finding',
        'NG'        => 'Not Guilty',
        'NOB'       => 'No Bill',
        'NPC'       => 'No Probable Cause',
        'PARD'      => 'Pardoned',
        'PD'        => 'Paid',
        'PG'        => 'Plea of Guilty',
        'PROB'      => 'Probation',
        'PROB EXTN' => 'Probation Extension',
        'PROG'      => 'Program',
        'PTP'       => 'Pre-Trial Probation',
        'REM'       => 'Removed',
        'REST'      => 'Restitution',
        'RMT'       => 'Remitted',
        'ROR'       => 'Released on Recognizance',
        'R/R'       => 'Revise and Revoke Sentence',
        'RSVD'      => 'Revised',
        'SDP'       => 'Sexually Dangerous Person',
        'SENT'      => 'Sentance',
        'SP'        => 'Supervised Probation',
        'SFN'       => 'Suspended Fine',
        'TD'        => 'Terminated and Discharged',
        'VAC'       => 'Vacated',
        'VN'        => 'Violation of Probation',
        'VOP'       => 'Violation of Probation',
        'WAR'       => 'Warrant',
        'WD'        => 'Withdrawn',
        'WKND'      => 'Serving Weekends',
    ];


    /**
     * Codes used on Public Records
     * @var array
     */
    protected $PublicRecordTypeCodes = [
        'AM' =>  'Attachment',
        'CB' =>  'Civil judgment in bankruptcy',
        'CJ' =>  'Civil judgment',
        'CP' =>  'Child support',
        'CS' =>  'Civil suit filed',
        'DF' =>  'Dismissed foreclosure',
        'DS' =>  'Dismissal of court suit',
        'FC' =>  'Foreclosure',
        'FD' =>  'Forcible detainer',
        'FF' =>  'Forcible detainer dismissed',
        'FT' =>  'Federal tax lien',
        'GN' =>  'Garnishment',
        'HA' => 'Homeowner’s association assessment lien',
        'HF' =>  'Hospital lien satisfied HL Hospital lien',
        'JL' =>  'Judicial lien',
        'JM' =>  'Judgment dismissed',
        'LR' =>  'A lien attached to real property ML Mechanics lien',
        'PC' =>  'Paid civil judgment',
        'PF' =>  'Paid federal tax lien',
        'PG' =>  'Paving assessment lien',
        'PL' =>  'Paid tax lien',
        'PQ' =>  'Paving assessment lien satisfied PT Puerto Rico tax lien',
        'PV' =>  'Judgment paid, vacated',
        'RL' =>  'Release of tax lien',
        'RM' =>  'Release of mechanic\’s lien',
        'RS' =>  'Real estate attachment satisfied',
        'SF' =>  'Satisfied foreclosure',
        'SL' => 'State tax lien',
        'TB' => 'Tax lien relieved in bankruptcy',
        'TC' => 'Trusteeship canceled',
        'TL' => 'Tax lien',
        'TP' => 'Trusteeship paid/state amortization satisfied',
        'TR' =>  'Trusteeship paid/state amortization',
        'TX' =>  'Tax lien revived',
        'WS' =>  'Water and sewer lien',
        '1D' =>  'Chapter 11 bankruptcy dismissed',
        '1F' =>  'Chapter 11 bankruptcy filing',
        '1V' =>  'Chapter 11 bankruptcy voluntary dismissal',
        '1X' =>  'Chapter 11 bankruptcy discharged',
        '2D' =>  'Chapter 12 bankruptcy dismissed',
        '2F' =>  'Chapter 12 bankruptcy filing',
        '2V' =>  'Chapter 12 bankruptcy voluntary dismissal',
        '2X' =>  'Chapter 12 bankruptcy discharged',
        '3D' =>  'Chapter 13 bankruptcy dismissed',
        '3F' =>  'Chapter 13 bankruptcy filing',
        '3V' =>  'Chapter 13 bankruptcy voluntary dismissal',
        '3X' =>  'Chapter 13 bankruptcy discharged',
        '7D' =>  'Chapter 7 bankruptcy dismissed',
        '7F' =>  'Chapter 7 bankruptcy filing',
        '7V' =>  'Chapter 7 bankruptcy voluntary dismissal',
        '7X' =>  'Chapter 7 bankruptcy discharged',
    ];

    

    /**
     * Score Factor codes on how credit score was calculated
     * @var array
     */
    protected $ScoreFactorCodes = [
        '00' => 'No adverse factor',
        '01' => 'Amount owed on accounts is too high',
        '02' => 'Level of delinquency on accounts',
        '03' => 'Too few bank revolving accounts',
        '04' => 'Too many bank or national revolving accounts',
        '05' => 'Too many accounts with balances',
        '06' => 'Too many consumer finance company accounts',
        '07' => 'Account payment history is too new to rate',
        '08' => 'Too many inquiries last 12 months',
        '09' => 'Too many accounts recently opened',
        '10' => 'Proportion of balances to credit limits is too high on bank revolving or other revolving accounts',
        '11' => 'Amount owed on revolving accounts is too high',
        '12' => 'Length of time revolving accounts have been established',
        '13' => 'Time since delinquency is too recent or unknown',
        '14' => 'Length of time accounts have been established',
        '15' => 'Lack of recent bank revolving information',
        '16' => 'Lack of recent revolving account information',
        '17' => 'No recent non-mortgage balance information',
        '18' => 'Number of accounts with delinquency',
        '19' => 'Too few accounts currently paid as agreed',
        '20' => 'Length of time since derogatory public record or collection is too short',
        '21' => 'Amount past due on accounts',
        '22' => 'Account(s) not paid as agreed and/or legal item filed',
        '23' => 'Number of bank or national revolving accounts with balances',
        '24' => 'No recent revolving balances',
        '25' => 'Length of time installment loans have been established',
        '26' => 'Number of revolving accounts',
        '27' => 'Insufficient number of satisfactory accounts',
        '28' => 'Number of established accounts',
        '29' => 'No recent bankcard balances',
        '30' => 'Time since most recent account opening is too short',
        '31' => 'Too few accounts with recent payment information',
        '32' => 'Lack of recent installment loan information',
        '33' => 'Proportion of loan balances to loan amounts is too high',
        '34' => 'Amount owed on delinquent accounts',
        '36' => 'Length of time open installment loans have been established',
        '37' => 'Number of finance company accounts established relative to length of finance history',
        '38' => 'Serious delinquency, and derogatory public record or collection filed',
        '39' => 'Serious delinquency',
        '40' => 'Derogatory public record or collection filed',
        '41' => 'No recent retail balances',
        '42' => 'Length of time since most recent consumer finance co. account established',
        '50' => 'Lack of recent retail account information',
        '56' => 'Amount owed on retail accounts',
        '98' => 'Lack of recent auto finance loan information',
        '99' => 'Lack of recent consumer finance company account information',
    ];



    /**
     * Remarks codes used in the remarks of Trade Lines and Public records
     * @var array
     */
    protected $RemarksCodes = [
        'AAP' => 'Loan assumed by another party',
        'ACR' => 'Account closed due to refinance',
        'ACQ' => 'Acquired from another lender',
        'ACT' => 'Account closed due to transfer',
        'AFR' => 'Account acquired by RTC/FDIC/NCUA',
        'AID' => 'Account information disputed by consumer',
        'AJP' => 'Adjustment pending',
        'AMD' => 'Active military duty',
        'AND' => 'Affected by natural/declared disaster',
        'BAL' => 'Balloon payment',
        'BCD' => 'Bankruptcy/dispute of account information/account closed by consumer',
        'BKC' => 'Bankruptcy/account closed by consumer',
        'BKD' => 'Bankruptcy/dispute of account information',
        'BKL' => 'Included in bankruptcy',
        'BDW' => 'Bankruptcy withdrawn',
        'BRC' => 'Bankruptcy/dispute resolved/consumer disagrees/account closed by consumer',
        'BRR' => 'Bankruptcy/dispute resolved/consumer disagrees',
        'CAD' => 'Dispute of account information/closed by consumer',
        'CBC' => 'Account closed by consumer',
        'CBD' => 'Dispute resolved; consumer disagrees/account closed by consumer',
        'CBG' => 'Account closed by credit grantor',
        'CBL' => 'Chapter 7 bankruptcy',
        'CBR' => 'Chapter 11 bankruptcy CBT Chapter 12 bankruptcy',
        'CCD' => 'Account closed by consumer/Chapter 7',
        'CDC' => 'Chap. 7/dispute of account information/account closed by consumer',
        'CDD' => 'Account closed by consumer/Chapter 11',
        'CDL' => 'Chap. 7/dispute of account information',
        'CDR' => 'Chap. 11/dispute of account information',
        'CDT' => 'Chap. 12/dispute of account information',
        'CED' => 'Account closed by consumer/Chapter 12',
        'CFD' => 'Account in dispute/closed by consumer',
        'CLA' => 'Placed for collection',
        'CLB' => 'Contingent liability—corporate defaults',
        'CLO' => 'Closed',
        'CLS' => 'Credit line suspended',
        'CPB' => 'Customer pays balance in full each month',
        'CRC' => 'Chap. 11/dispute of account information/account closed by consumer',
        'CRD' => 'Chap. 7/dispute resolved/consumer disagrees/account closed by consumer',
        'CRL' => 'Chap. 7/dispute resolved/consumer disagrees',
        'CRR' => 'Chap. 11/dispute resolved/consumer disagrees/account closed by consumer',
        'CRT' => 'Chap. 12/dispute resolved/consumer disagrees/account closed by consumer',
        'CRV' => 'Chap. 11/dispute resolved/consumer disagrees',
        'CTR' => 'Account closed—transfer or refinance',
        'CTS' => 'Contact subscriber',
        'CTC' => 'Chap. 12/dispute of account information/account closed by consumer',
        'CTV' => 'Chap. 12/dispute resolved/consumer disagrees',
        'DEC' => 'Deceased',
        'DLU' => 'Deed in lieu',
        'DM' => 'Bankruptcy dismissed',
        'DRC' => 'Dispute resolved—customer disagrees',
        'DRG' => 'Dispute resolved reported by grantor',
        'ER' => 'Election of remedy',
        'ETB' => 'Early termination/balance owing',
        'ETD' => 'Early termination by default',
        'ETI' => 'Early termination/insurance loss',
        'ETO' => 'Early termination/obligation satisfied',
        'ETS' => 'Early termination/status pending',
        'FCL' => 'Foreclosure',
        'FOR' => 'Account in forbearance',
        'FPD' => 'Account paid, foreclosure started',
        'FPI' => 'Foreclosure initiated',
        'FRD' => 'Foreclosure, collateral sold',
        'FTB' => 'Full termination/balance owing',
        'FTO' => 'Full termination/obligation satisfied',
        'FTS' => 'Full termination/status pending',
        'INA' => 'Inactive account',
        'INP' => 'Debt being paid through insurance',
        'INS' => 'Paid by insurance',
        'IRB' => 'Involuntary repossession/balance owing',
        'IRE' => 'Involuntary repossession',
        'IRO' => 'Involuntary repossession/obligation satisfied',
        'JUG' => 'Judgment granted',
        'LA' => 'Lease Assumption',
        'MCC' => 'Managed by debt counseling service',
        'MOV' => 'No forwarding address',
        'ND' => 'No dispute',
        'NIR' => 'Student loan not in repayment',
        'NPA' => 'Now paying',
        'PAL' => 'Purchased by another lender',
        'PCL' => 'Paid collection',
        'PDD' => 'Paid by dealer',
        'PDE' => 'Payment deferred',
        'PDI' => 'Principal deferred/interest payment only',
        'PFC' => 'Account paid from collateral',
        'PLL' => 'Prepaid lease',
        'PLP' => 'Profit and loss now paying',
        'PNR' => 'First payment never received',
        'PPA' => 'Paying partial payment agreement',
        'PPD' => 'Paid by comaker',
        'PPL' => 'Paid profit and loss',
        'PRD' => 'Payroll deduction',
        'PRL' => 'Profit and loss write-off',
        'PWG' => 'Account payment, wage garnish',
        'REA' => 'Reaffirmation of debt',
        'REP' => 'Substitute/Replacement account',
        'RFN' => 'Refinanced',
        'RPD' => 'Paid repossession',
        'RPO' => 'Repossession',
        'RRE' => 'Repossession; redeemed',
        'RVN' => 'Voluntary surrender',
        'RVR' => 'Voluntary surrender redeemed',
        'SET' => 'Settled—less than full balance',
        'SGL' => 'Claim filed with government',
        'SIL' => 'Simple interest loan',
        'SLP' => 'Student loan perm assign governmen',
        'SPL' => 'Single payment loan',
        'STL' => 'Credit card lost or stolen',
        'TRF' => 'Transfer',
        'TRL' => 'Transferred to another lender',
        'TTR' => 'Transferred to recovery',
        'WCD' => 'Chap. 13/dispute of account information/account closed by consumer',
        'WEP' => 'Chap. 13 bankruptcy',
        'WPC' => 'Chap. 13/account closed by consumer',
        'WPD' => 'Chap. 13/dispute of account information',
        'WRC' => 'Chap. 13/dispute resolved/consumer disagrees/account closed by consumer',
        'WRR' => 'Chap. 13/dispute resolved/consumer disagrees',
    ];

    

    /**
     * Payment Pattern logic for Trade Line Payment history
     * @var array
     */
    protected $PaymentPatternLogic = [
        '1'     => 'Paid As Agreed',
        '01'    => 'Paid As Agreed',
        '2'     => '30 days past due',
        '02'    => '30 days past due',
        '3'     => '60 days past due',
        '03'    => '60 days past due',
        '4'     => '90 days past due',
        '04'    => '90 days past due',
        '5'     => '120 days past due',
        '05'    => '120 days past due',
        'X'     => 'Unclassified',
        '00'    => 'Unclassified',
        'UC'    => 'Unclassified',
        'UR'    => 'Unclassified',
    ];

    protected $AddressQualifier = [
        '1' => 'Personal',
        '2' => 'Employment',
        '3' => 'Credit Grantor',
        '5' => 'Business',
        '6' => 'Not Known',
        'P' => 'Previous Peronsal Address'
    ];

    protected $SourceIndicator = [
        'P' => 'Previous Personal Address',
        'I' => 'Address received as part of this inquiry for the consumer\'s information',
        'F' => 'Address contained in bureau database',
        'A' => 'Address that appears on the RPA database',
        'D' => 'Address contained in the vendor\'s database'
    ];

    protected $StatementTypeCode = [
        '01'    => 'Regular consumer statement',
        '02'    => 'Statement added because consumer was a victim of true-name fraud'
    ];

    protected $DerogAlertCode = [
        'A' => 'Derogatory info is in the file and, for models that indicate it, inquiries did not impact the credit score',
        'I' => 'Inquiries did impact the credit score and, for models that indicate it, no derogatory info was found in the file',
        'B' => 'Derogatory info is in the file and inquiries did impact the credit score',
        '0' => 'No derogatory info was found in the file and/or inquiries did not impact the credit score'
    ];

    protected $TermsFrequencyOfPaymentCodes = [
        'D'	=> 'Deferred',
        'P'	=> 'Payroll or deduction',
        'W'	=> 'Weekly',
        'B'	=> 'Biweekly',
        'E'	=> 'Semimonthly',
        'M'	=> 'Monthly',
        'L'	=> 'Bimonthly',
        'Q'	=> 'Quarterly',
        'T'	=> 'Every 4 Months',
        'S'	=> 'Semiannually',
        'Y'	=> 'Annually',
        'X'	=> 'Unspecified',
        'V'	=> 'Variable payment',
    ];

    protected $DateClosedIndicatorCodes = [
        'C' => 'Account was closed normally',
        'F' => 'Account was closed because of charge- off or Repossession',
    ];

    public function paymentPattern($code)
    {
        return $this->PaymentPatternLogic[$code];
    }

    protected function _decode($code, $dictionary)
    {
        if( !is_string($code) && !is_int($code)) return null;
        
        if( !property_exists($this, $dictionary) ) return null;

        $dictionary = $this->$dictionary;

        return array_key_exists($code, $dictionary) ? $dictionary[$code] : $code;
    }

    /**
     * Compares the provided array against an array of keys that it should contain 
     * and returns an array of the keys that are missing
     * @param  array $should An array containing as values the name of the keys that should exist
     * @param  array $array  The actual array to check
     * @return array         The difference
     */
    protected function _missing($should, $array)
    {
        if( !is_array($array)) return [];
        $array = array_keys($array);

        return array_diff($should, $array);
    }

    /**
     * Helper Function to remove unneeded Indexes 
     * 
     * @param  arrau $removeIfExists A list of the keys to be removed
     * @param  array $item           The array to remove the keys from
     * @return array                 The sanitized array
     */
    protected function _remove($removeIfExists, $item)
    {
        foreach($removeIfExists as $remove) {
            if(array_key_exists($remove, $item)) unset($item[$remove]);
        }

        return $item;
    }

    /**
     * Add missing entires into the array
     * 
     * @param array $shouldExist A list of keys that should exist in the array
     * @param array $item        The array that should contain the vlaues
     * @return array            The sanitized array
     */
    protected function _addMissing($shouldExist, $item)
    {
        foreach($this->_missing($shouldExist, $item) as $missing) {
            $item[$missing] = null;
        }

        return $item;
    }
}
