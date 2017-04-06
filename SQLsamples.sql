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


--get AGGREGATED DATA FOR MODULE
SELECT SPR_CODE, QUE_CODE, RES_VALU
        FROM INS_RES
        WHERE MOD_CODE='CSN08101'
        ORDER BY QUE_CODE;

        SELECT QUE_CODE, 100*AVG(RES_VALU)  AS results
                FROM INS_RES
                WHERE MOD_CODE='CSN08101'
                GROUP BY QUE_CODE ORDER BY QUE_CODE;


SELECT QUE_CODE, COUNT(RES_VALU)  AS results
                FROM INS_RES
                WHERE MOD_CODE='CSN08101'
                GROUP BY  QUE_CODE ORDER BY QUE_CODE
                ;















SELECT INS_RES.MOD_CODE, INS_RES.QUE_CODE, INS_QUE.QUE_TEXT,
    100*AVG(CASE WHEN RES_VALU IN (4,5) THEN 1 ELSE 0 END)  AS results,
    COUNT(RES_VALU)
        FROM INS_RES
        JOIN INS_QUE ON(INS_QUE.QUE_CODE=INS_RES.QUE_CODE)
        WHERE MOD_CODE='CSN08101'
        GROUP BY INS_RES.MOD_CODE, QUE_CODE,INS_QUE.QUE_TEXT ORDER BY QUE_CODE;