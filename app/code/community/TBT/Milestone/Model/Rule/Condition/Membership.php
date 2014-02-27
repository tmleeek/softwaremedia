<?php

class TBT_Milestone_Model_Rule_Condition_Membership extends TBT_Milestone_Model_Rule_Condition
{
    const POINTS_REFERENCE_TYPE_ID = 602;

    protected $_notification_email = true;
    protected $_notification_frontend = false;
    protected $_notification_backend = false;

    public function getMilestoneName()
    {
        return Mage::helper('tbtmilestone')->__("Length of Membership");
    }

    public function getMilestoneDescription()
    {
        return Mage::helper('tbtmilestone')->__("membership period of %s days", $this->getThreshold());
    }

    public function isSatisfied($customerId)
    {
        /**
         * This type of condition comes with a prequalifier
         * which would have already ensured that the rule
         * is satisfied for the customer.
         *
         * @see TBT_Milestone_Model_Rule_Condition_Membership_Prequalifier::getCollection()
         */

        return true;
    }

    public function validateSave()
    {
        if (!$this->getThreshold()) {
            throw new Exception("The milestone threshold is a required field.");
        }

        return $this;
    }

    /**
     * @return int. The Transfer Refrence Type ID used to identify this type of rule.
     * @see TBT_Milestone_Model_Rule_Condition::getPointsReferenceTypeId()
     */
    public function getPointsReferenceTypeId()
    {
        return self::POINTS_REFERENCE_TYPE_ID;
    }
}