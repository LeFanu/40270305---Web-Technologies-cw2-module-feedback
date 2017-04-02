--GET THE STUDENT BY THE NAME
SELECT SPR_FNM1, SPR_SURN FROM INS_SPR WHERE SPR_CODE=?


--CAM_SMO contains mattriculation numbers, module numbers, year and tr1
--INS_CAT are categories for questions
--INS_MOD contains modules details
-- INS_PRS contains teaching staff
-- INS_RES are the results for the survey
--INS SPR are all the students




--GET THE moduleCode, Module name
 SELECT CAM_SMO.MOD_CODE, MOD_NAME
 FROM CAM_SMO
 JOIN INS_MOD ON (CAM_SMO.MOD_CODE=INS_MOD.MOD_CODE)
 WHERE SPR_CODE='50200036' AND AYR_CODE='2016/7' AND PSL_CODE='TR1';
