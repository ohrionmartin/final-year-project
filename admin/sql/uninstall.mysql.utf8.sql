DROP TABLE IF EXISTS `#__eclinic_portal_payment`;
DROP TABLE IF EXISTS `#__eclinic_portal_general_medical_check_up`;
DROP TABLE IF EXISTS `#__eclinic_portal_antenatal_care`;
DROP TABLE IF EXISTS `#__eclinic_portal_immunisation`;
DROP TABLE IF EXISTS `#__eclinic_portal_vmmc`;
DROP TABLE IF EXISTS `#__eclinic_portal_prostate_and_testicular_cancer`;
DROP TABLE IF EXISTS `#__eclinic_portal_tuberculosis`;
DROP TABLE IF EXISTS `#__eclinic_portal_hiv_counseling_and_testing`;
DROP TABLE IF EXISTS `#__eclinic_portal_family_planning`;
DROP TABLE IF EXISTS `#__eclinic_portal_cervical_cancer`;
DROP TABLE IF EXISTS `#__eclinic_portal_breast_cancer`;
DROP TABLE IF EXISTS `#__eclinic_portal_test`;
DROP TABLE IF EXISTS `#__eclinic_portal_testing_reason`;
DROP TABLE IF EXISTS `#__eclinic_portal_counseling_type`;
DROP TABLE IF EXISTS `#__eclinic_portal_group_health_education_topic`;
DROP TABLE IF EXISTS `#__eclinic_portal_individual_health_education_topic`;
DROP TABLE IF EXISTS `#__eclinic_portal_individual_health_education`;
DROP TABLE IF EXISTS `#__eclinic_portal_group_health_education`;
DROP TABLE IF EXISTS `#__eclinic_portal_foetal_engagement`;
DROP TABLE IF EXISTS `#__eclinic_portal_administration_part`;
DROP TABLE IF EXISTS `#__eclinic_portal_planning_type`;
DROP TABLE IF EXISTS `#__eclinic_portal_immunisation_type`;
DROP TABLE IF EXISTS `#__eclinic_portal_foetal_lie`;
DROP TABLE IF EXISTS `#__eclinic_portal_foetal_presentation`;
DROP TABLE IF EXISTS `#__eclinic_portal_nonpay_reason`;
DROP TABLE IF EXISTS `#__eclinic_portal_immunisation_vaccine_type`;
DROP TABLE IF EXISTS `#__eclinic_portal_payment_amount`;
DROP TABLE IF EXISTS `#__eclinic_portal_diagnosis_type`;
DROP TABLE IF EXISTS `#__eclinic_portal_payment_type`;
DROP TABLE IF EXISTS `#__eclinic_portal_medication`;
DROP TABLE IF EXISTS `#__eclinic_portal_site`;
DROP TABLE IF EXISTS `#__eclinic_portal_referral`;
DROP TABLE IF EXISTS `#__eclinic_portal_clinic`;


--
-- [Interpretation 10740] Always insure this column rules is reversed to Joomla defaults on uninstall. (as on 1st Dec 2020)
--
ALTER TABLE `#__assets` CHANGE `rules` `rules` varchar(5120) NOT NULL COMMENT 'JSON encoded access control.';

--
-- [Interpretation 10759] Always insure this column name is reversed to Joomla defaults on uninstall. (as on 1st Dec 2020).
--
ALTER TABLE `#__assets` CHANGE `name` `name` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The unique name for the asset.';
