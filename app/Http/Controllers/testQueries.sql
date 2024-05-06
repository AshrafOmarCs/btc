select journal_period as id,journal_period as name from(

            select journal_period FROM
            (
            select if (period_start<>1,
                            CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', LPAD(period_start, 2, '01'),
                            ' - ',date_format(journal_date - interval period_start-1 day + INTERVAL 1 MONTH, '%Y-%m'),'-', LPAD(period_end, 2, '0')),
                            CONCAT(date_format(journal_date - interval period_start-1 day, '%Y-%m'), '-', LPAD(period_start, 2, '0'),
                            ' - ',date_format(journal_date - interval period_start-1 day, '%Y-%m'),'-', LPAD(period_end, 2, '0')))
                             as journal_period
                from journal
                    inner join drivers on drivers.id=journal.driverId
                inner join warehouse on warehouse.id=drivers.warehouseId
                inner join lkp_company on lkp_company.id=warehouse.companyId
                where companyId=1)a
            GROUP BY journal_period
            order by journal_period desc)n