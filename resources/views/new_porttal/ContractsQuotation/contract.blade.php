<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contract</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <center><button style="" class="btn submit" onclick="export_pdf('{{$company}}')">Export PDF</button></center>
    <div class="container" id="printableSection">
        <style>
            /* Add your CSS styles here */
            body {
                font-family: Arial, sans-serif;
                background-color: #f5f5f5;
            }
            .container {
                max-width: 90%;
                margin: 0 auto;
                padding: 20px;
                background-color: #ffffff;
                border-radius: 5px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }
            h1 {
                color: #333;
            }
            .btn {
                display: inline-block;
                padding: 10px 20px;
                background-color: #007BFF;
                color: #ffffff;
                text-decoration: none;
                border-radius: 5px;
            }
            .submit {
                display: inline-block;
                padding: 10px 20px;
                background-color: #007BFF;
                color: #ffffff;
                text-decoration: none;
                border-radius: 5px;
                transition: background-color 0.3s ease-in-out;
            }
            .submit:hover {
                background-color: #c82333; /* Change to a different color on hover */
            }

            .container {
                width: 100%; /* Set a fixed width or percentage as needed */
                overflow-x: auto;
            }
            td, th {
                width: 50%;
                padding: 15px;
            }
            .table-container {
                display: block;
                width: 98%;
                border: 1px solid black;
                margin: 0 auto;
                padding: 10px;
            }

            /* Styles for each "row" */
            .table-row {
                display: flex;
                border-bottom: 1px solid black;
                padding: 10px 0;
            }

            /* Styles for each "cell" */
            .table-cell {
                padding: 5px;
                text-align: justify;
            }

            /* Header cell */
            .table-header {
                font-weight: bold;
            }
            .img-width {
                width: 200px;
                height: 140px;
            }
            .by-margin {
                margin-top: 65px;
            }
            .bor-heigt {
                height: 150vh;
                background-size: 100% 100%;
            }
            .qr_code {
                width: 150px;
                height: 150px
            }
            .ml_125 {
                margin-left: 135px;
            }
            .watermark {
                position: fixed; top: 50%;
                left: 50%; transform: translate(-50%, -50%);
                opacity: 0.3; font-size: 36px;
                font-weight: bold;color: #d3d3d3;
                pointer-events: none;
            }
            .padd-top {
                padding-top: 50px;
            }
            @media (max-width: 768px) {
                .bor-heigt {
                    /*width: 182% !important;*/
                    height: 95%;
                    padding: 10px; /* Adjust padding for smaller screens */
                    border: 10px; /* Adjust border width for smaller screens */
                    background-size: 100% 85%;
                }
                .img-width {
                    width: 70px;
                    height: 35px;
                }
                .by-margin {
                    margin-top: 15px;
                }

                .qr_code {
                    width: 100px;
                    height: 100px
                }
                .ml_125 {
                    margin-left: 33px;
                }
                .padd-top {
                    padding-top: 20px;
                }

                .watermark {
                    position: fixed; top: 50%;
                    left: 50%; transform: translate(-50%, -50%);
                }
            }
        </style>
        <!--page-break-after: always;-->
        <div style="width: 100%;
            min-height: 100vh; /* Set a minimum height to ensure content is visible */
            display: flex;
            justify-content: center;
            align-items: center;
            ">
            <h1 style="max-width: 90%; text-align: center;">Shipment Services Agreements <br>({{$company}} App Market)</h1>
        </div>

        <!--<center><h1>Contract</h1></center>-->
        @if($row[0]->contractType == 1)
            <div class="table-responsive">
                <table class="table" style="text-align: justify; border-collapse: collapse;">
            <tr style="border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000">
                <td style="border-right: 1px solid #000;"><b>THIS MANPOWER SERVICES AGREEMENT is made on {{$row[0]->cont_start_date}} between:</b></td>
                <td style="direction: rtl;"><b>أبرمت اتفاقية خدمات العمالة هذه بتاريخ {{$row[0]->cont_start_date}} بین کلاً :</b></td>
            </tr>

            <tr style="border-right: 1px solid #000; border-left: 1px solid #000">
                <td style="border-right: 1px solid #000;"><b>1 Company: Bandar Trading Company: - for Logistics</b>.<br><br>
                C.R.Number: 1010607540<br>
                VAT Registration No: 310462974800003 <br>
                E-mail. cpm@btclogistic.com<br>
                represented herein by Bandar Trading Company in RIYADH referred to as the (the First Party).
                </td>
                <td style="direction: rtl;"><b> شركة / بندر التجارية ( شركة شخص واحد ) وعنوانها الرياض – النرجس</b>
                    <br> سجل رقم : 1010607540
                    <br>ورقم تسجيلها الضريبي: 310462974800003
                    <br>البريد الالكتروني :  cpm@btclogistic.com
                    <br>  ويمثلها / السيد....بندر منصور ال عامر   ويشار إليها في هذا العقد بـ
                        (الطرف الأول)
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000; border-bottom: 1px solid #000">
                <td style="border-right: 1px solid #000;"><br><b>2 Company: {{$company}}</b> in {{$row[0]->national_address_en}}<br> C. R. No. {{$row[0]->reg_number}} <br>
                VAT Registration No. {{$row[0]->vat_certificate_number}}<br>E-mail. {{$row[0]->companyEmail}}<br> represented herein by {{$row[0]->info_person_name}} hereinafter referred to as the (the Second Party).
                </td>
                <td style="direction: rtl;"><br><b>وشركة{{$row[0]->companyName_ar}}}</b> وعنوانها: {{$row[0]->national_address_ar}}
                <br>سجل رقم :{{$row[0]->reg_number}}
                <br>    الرقم الضريبي : {{$row[0]->vat_certificate_number}}
                <br>    البريد الالكتروني :     {{$row[0]->companyEmail}}
                <br>    ويمثلها / السيد : {{$row[0]->info_person_name_ar}}  ويشار إليها في هذا العقد بـ
                    (الطرف الثاني)
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000; border-top: 1px solid #000">
                <td style="border-right: 1px solid #000;"><br><h4>BACKGROUND</h4></td>
                <td style="direction: rtl;"><br><h4>                    فكرة عامة</h4></td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000; border-bottom: 1px solid #000">
                <td style="border-right: 1px solid #000;">
                    The Company has agreed to provide the Services (as
                    defined below) to Bandar Trading Company (one person company) on the terms and conditions set out in this Agreement.  The terms of this Agreement are:
                </td>
                <td style="direction: rtl;">                    وافق كلا الأطراف علي تبادل الخدمات  فيما بينهم البين  (كما هي معرفة أدناه) بناءً على الأحكام والشروط المنصوص عليها في هذه الاتفاقية.  وتتمثل أحكام هذه الاتفاقية فيما يلي
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;"><br><h4>1. DEFINITIONS AND INTERPRETATIONS</h4></td>
                <td style="direction: rtl;"><br><h4>                    ١.	التعريفات والتفسيرات
                    </h4>
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">
                    The expressions which follow are given these meanings unless the context in which they are used requires a different meaning:<br>
                    "Annexure" the format setting out the Rates and Services to be provided by the Company; "Confidential Information" means information that is designated as 'confidential' or which by its nature is clearly confidential.
                    Confidential Information includes (without limitation) any information concerning the technology, technical processes, business processes, procedures, business affairs, financial affairs and finance of either party, its customers, employees and service providers.
                    Each party's security procedures and the layout of premises are also included within the definition of Confidential Information;
                </td>
                <td style="direction: rtl;">تنسب هذه المعاني للعبارات التالية، ما لم يتطلب السياق- الذي تستخدم فيه - معنى مختلف.
                    <br>"الملحق" الصيغة التي تحدد الأسعار والخدمات التي ستقدمها الشركة ؛ “المعلومات السرية" يقصد بها المعلومات المسماة "سرية" أو تعد بطبيعتها سرية على نحو واضح. وتشمل المعلومات السرية (دون الحصر) أي معلومات خاصة بالتقنية والعمليات الفنية والعمليات التجارية والإجراءات وشؤون العمل والشؤون المالية والتمويل لدى أي من الطرفين وعملائه وموظفيه ومقدمي الخدمات لديه.  تُعد الإجراءات الأمنية لكل طرف ومخطط المقر من ضمن المعلومات السرية.
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">“Effective Date” means the date mentioned in the Appendix.</td>
                <td style="direction: rtl;">"تاريخ السريان" التاريخ المذكور في الملحق.</td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">“Employee(s)” means any individual employed by the First Party Company and sent to the Second Party pursuant to and in accordance with the terms of this Agreement.</td>
                <td style="direction: rtl;">
                    "الموظف/الموظفون" يقصد به أي فرد توظفه شركة الطرف الأول  ,ويبعث إلى الطرف الثاني  عملاً ووفقاً بشروط هذه الاتفاقية.
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">“Fees” means the fees stated in the Purchase Order and in accordance with</td>
                <td style="direction: rtl;">
                    "الرسوم" يقصد بها الرسوم الواردة في أمر الشراء والتي تتوافق مع
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">The prices mentioned in the appendix that will be paid by the Second party in accordance with Clause 3.</td>
                <td style="direction: rtl;">
                    الأسعار الواردة في الملحق والتي سيقوم الطرف الثاني  بسدادها وفقا للبند ٣.
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">"Good Industry Practice" means the standard of skill, care, knowledge, reliability, professionalism and foresight which would reasonably and ordinarily be expected from an experienced person engaged in providing services which are the same as, or similar to, the Services;</td>
                <td style="direction: rtl;">
                "الممارسات الصناعية الجيدة" تعني معيار المهارة والرعاية والمعرفة والموثوقية والكفاءة المهنية والبصيرة التي يمكن توقعها بشكل معقول وعادي من شخص ذي خبرة يشارك في تقديم الخدمات التي تشبه الخدمات أو تشبهها؛
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #000; border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">"Purchase Order" means the agreed purchase order between the Parties, on which the Company will commence the Services; "Rates" means the fixed rates detailed in the Annexure;
                "Services" means the manpower services to be provided by Company under this Agreement; and "Term" means a period detailed in the Annexure.</td>
                <td style="direction: rtl;">
                    " الممارسة الجيدة في القطاع " يقصد بها مستوى المهارة والرعاية والمعرفة وامكانية الاعتماد والموثوقية والكفاءة المهنية والبصيرة المتوقعة من شخص ذو خبرة يعمل في تقديم الخدمات التي هي نفس الخدمات أو مماثلة لها.

                    "أمر الشراء" يقصد به أمر الشراء المتفق عليه بين الطرفين والذي ستعمل الشركة بموجبه لتوفير الخدمات. "الأسعار" يقصد بها الأسعار الثابتة المذكورة في الملحق. "الخدمات" يقصد بها خدمات توفير العمالة التي من ستوفرها الشركة هذه الاتفاقية. بموجب "المدة" يقصد بها المدة الموضحة في الملحق.
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;"><br><h4>2. SERVICES</h4></td>
                <td style="direction: rtl;">
                    <h4><br>
                        ٢. الخدمات
                    </h4>
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">2.1. The Second party company will provide  perform the Services in accordance with the terms of this Agreement, Annexure and the relevant Purchase Order.</td>
                <td style="direction: rtl;">
                    ٢.١. ستوفر شركة الطرف الثاني الخدمات بموجب الشروط الواردة في هذه الاتفاقية والملحق وأمر الشراء ذي الصلة.
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">2.2. The First party company undertakes to the Second party that the services will be carried out in accordance with all applicable laws, rules, regulations, orders, licenses, permits and other governmental requirements.
                If the annex or the purchase order does not specify the implementation dates and the stages of completing the services, the Second party company must implement these services according to the good practice in the sector.</td>
                <td style="direction: rtl;">
                    ٢.٢. تتعهد شركة الطرف الأول لـ الطرف الثاني  بأنه سيتم تنفيذ الخدمات وفقا لجميع القوانين المعمول بها والقواعد والأنظمة والأوامر والتراخيص والتصاريح والمتطلبات الحكومية الأخرى. اذا لم يحدد الملحق أو أمر الشراء مواعيد التنفيذ ومراحل انجاز الخدمات يجب على شركة الطرف الثاني تنفيذ هذه الخدمات بموجب الممارسة الجيدة في القطاع.
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">2.3. In the event of any conflict or inconsistency between them, the terms of the main body of this Agreement will prevail over the terms of the Annexure  or Purchase Order,
                and the relevant provisions of the Annexures and Purchase Order should be construed accordingly.</td>
                <td style="direction: rtl;">
                    ٢.٣. في حالة حدوث أي تعارض أو تناقض بين هذا العقد وأي ملحق أو أمر شراء، تسود شروط اتفاقية الخدمات الرئيسية على شروط الملحق أو أمر شراء، ويجب تفسير الأحكام ذات الصلة من الملحقات وأمر الشراء وفقا لذلك.
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">2.4. The First party is obligated to distribute employees who meet the technical and other skills determined by the Second party and required to implement the services.
                Bandar Company (one person company) reserves the right to replace the distributed employees with other employees who meet the requirements of the Second party at any time throughout the duration of this agreement.
                The company makes every effort to achieve the Second party's request to make any modifications to the employees' uniform.</td>
                <td style="direction: rtl;">
                    ٢.٤. يلتزم الطرف الأول بتوزيع الموظفين الذين يستوفون المهارات الفنية وغيرها من المهارات التي تحددها الطرف الثاني  وتلزم لتنفيذ الخدمات. وتحتفظ شركة بندر (شركة شخص واحد)بالحق في الاستعاضة عن الموظفين الموزعين بموظفين آخرين يستوفون اشتراطات الطرف الثاني  وذلك في أي وقت طوال مدة هذه الاتفاقية. وتبذل الشركة أقصى مساعيها لتحقيق طلب الطرف الثاني  بإجراء أي تعديلات على الزي الموحد للموظفين.
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">2.5. The First party company is committed to making every effort to solve any problems or difficulties that arise between the Second party and the employees.
                The company replaces any employees based on receiving a reasonable written request from the Second party to clarify the reasons related to the unsatisfactory
                performance of services as soon as it has the resources to do so and no later than seven (7) days from receiving the request.</td>
                <td style="direction: rtl;">
                    ٢.٥	. تلتزم شركة الطرف الأول  ببذل أقصى مساعيها لحل أي مشكلات أو صعوبات تنشأ فيما بين الطرف الثاني والموظفين. وتستعيض الشركة عن أي موظفين بناءً على تسلم طلب خطي معقول من الطرف الثاني  لتوضيح الأسباب ذات الصلة بأداء الخدمات على نحو غير مرض وذلك في أسرع وقت متى كان لديها الموارد للقيام بهذا وفي موعد أقصاه سبعة (٧) أيام من تسلم الطلب.
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">2.6. The First party is responsible for the actions and negligence of its employees, including the loss or theft of any of the Second party's property (or any property of others) by the employee.
                The Second party shall have the right to deduct such relevant amounts from the company's invoices. In addition, the First party is obligated to ensure that all stolen items are returned to the Second party,
                if they are still in the possession of the employee.</td>
                <td style="direction: rtl;">
                    ٢.٦.يعد الطرف الأول مسؤول عن أعمال موظفيها و اهمالهم، بما في ذلك فقدان أو سرقة أي من ممتلكات الطرف الثاني (أو أي ممتلكات للغير) من قبل الموظف . ويحق الطرف الثاني  أن يقتطع تلك المبالغ ذات الصلة من فواتير الشركة. وإضافة إلى ذلك، يلتزم الطرف الأول بالتأكد من إعادة كافة المسروقات إلى الطرف الثاني  ، إذا كانت ما تزال في حيازة الموظف.
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #000; border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">2.7 If the First party does not provide services or personnel within the time period specified in the appendix and the purchase order, the Second party is entitled to a refund
                Contractual compensation from the First party under the relevant attachment and purchase order.</td>
                <td style="direction: rtl;">
                    ٢.٧ إذا لم يقوم الطرف الأول بتوفير الخدمات أو الموظفين خلال المدة الزمنية المحددة في الملحق وأمر الشراء، فيحق لـ الطرف الثاني  استرداد التعويضات التعاقدية من الطرف الأول بموجب الملحق ذي الصلة وأمر الشراء.
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;"><br><h4>3.FEES AND PAYMENT</h4></td>
                <td style="direction: rtl;"><br><h4>
                    ٣. الرسوم والدفع
                </h4></td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">3.1 The Second party pays the fees provided in the purchase order to the First party under this Clause (3) for the implementation of services in a timely manner and with professional quality.</td>
                <td style="direction: rtl;">
                    ٣.١. سوف يقوم الطرف الثاني  بدفع الرسوم المذكورة في أمر الشراء للطرف الأول بموجب هذا البند (٣) لتنفيذ الخدمات في التوقيت الملائم وبالجودة المهنية.
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">3.2 Invoices are submitted to the Second party as indicated in the relevant purchase order. The undisputed due amounts will be paid by the Second party to the First party within (7) days after receiving the invoice(s) and verifying their authenticity.</td>
                <td style="direction: rtl;">
                    ٣.٢. يتم تقديم الفواتير إلى الطرف الثاني  كما هو مبين في أمر الشراء ذي الصلة. وسيتم سداد المبالغ المستحقة غير المتنازع عليها من قبل الطرف الثاني  للطرف الأول خلال (٧) ايام بعد استلام الفاتورة/الفواتير والتحقق من صحتها .
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #000; border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">3.3. Fees include all travel and other incidental expenses incurred by the First Party, unless otherwise specified in the relevant Appendix. All fees charged by the Company shall be exclusive of any applicable sales, use,
                value added tax or other taxes or any amount that may be charged or based on the services provided under this Agreement.</td>
                <td style="direction: rtl;">
                    ٣.٣. تشمل الرسوم جميع مصاريف السفر والمصروفات العرضية الأخرى التي يتكبدها الطرف الأول، ما لم ينص على خلاف ذلك في الملحق ذات الصلة. يجب أن تكون جميع الرسوم التي تتقاضاها الشركة غير شاملة لأي من المبيعات المطبقة، والاستخدام، وضريبة القيمة المضافة أو الضرائب الأخرى أو أي مبلغ يمكن فرضه أو يكون بناء على الخدمات المقدمة بموجب هذه الاتفاقية.
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;"><br><h4>4.CONFIDENTIALITY</h4></td>
                <td style="direction: rtl;">
                    <br><h4>
                        ٤. السرية
                    </h4>
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">4.1. Both parties shall maintain the confidentiality of the confidential information that they obtain from each other under this agreement,
                and shall not disclose, publish or provide it to another party without obtaining the prior written consent of the party providing the confidential information,
                and the disclosure and use of this confidential information shall be only for the purpose of implementing the obligations under this agreement.</td>
                <td style="direction: rtl;">
                    ٤.١	. يحافظ كلا الأطراف   على سرية المعلومات السرية التي يحصلان عليها من بعضهما البعض بموجب هذه الاتفاقية، وعدم الإفصاح عنها أو نشرها أو تقديمها الى طرف آخر دون الحصول على موافقة خطية مسبقة من الطرف المقدم للمعلومات السرية، ويكون الإفصاح عن واستخدام هذه المعلومات السرية فقط لغرض تنفيذ الإلتزامات بموجب هذه الاتفاقية.
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #000; border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">4.2. This Clause does not apply to information which the receiving party can show by reference to documentary or other evidence, a) was rightfully in its possession prior to disclosure to it by the other party;
                b) is already public knowledge or which becomes so at a future date (otherwise than as a result of breach of this Clause 0;
                c) is received from a third party who is not under an obligation of confidentiality in relation to the information;
                d) is developed independently without access to, or use or knowledge of, the Confidential Information;
                e) is trivial or obvious or
                f) is required to be disclosed by the receiving party in accordance with the applicable laws and orders from government or court; provided that,
                in this case, the receiving party shall provide prior written notice of such disclosure to the providing party and take reasonable and lawful actions.
                to avoid and/or minimise the degree of such disclosure.</td>
                <td style="direction: rtl;">
                    ٤.٢. لا ينطبق هذا البند على المعلومات التي يمكن أن تكون بحيازة الطرف المتلقي بالرجوع الى أدلة مستندية أو غيرها من الأدلة، (أ) إذا كانت في حيازة المتلقي قبل قيام المفصح عن المعلومات بالافصاح، (ب) أنها معروفة على الصعيد العام أو أصبحت معروفة للعامة في تاريخ لاحق (دون الإخلال بهذا البند) (ج) أنه تلقاها من الغير الذي لا يخضع لأي التزام سرية فيما يتعلق بالمعلومات، (د) أنها قد أعدت على نحو مستقل دون الاطلاع على المعلومات السرية أو استخدامها أو معرفتها، (ه) تكون غير مهمة أو واضحة، (و) أن الإفصاح عنها من قبل الطرف المتلقي مطلوب بموجب القوانين المعمول بها والأوامر الصادرة من الحكومة أو المحكمة؛ شريطة أنه يتعين على الطرف المتلقي في هذه الحالة أن يقدم إخطاراً خطياً مسبقاً بالإفصاح إلى الطرف المفصح وأن يتخذ إجراءات قانونية ومعقولة لتجنب درجة ذلك الإفصاح و/أو الحد منه.
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;"><br><h4>5.WARRANTIES AND REPRESENTATIONS</h4></td>
                <td style="direction: rtl;">
                    <br><h4>
                        ٥. الضمانات والإقرارات
                    </h4>
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">5.1. Each party represents and warrants to other party that, a) it has all necessary rights, power and authority and has taken all necessary action to enter into and perform this Agreement and to grant the rights herein; and
                b) its entry into and performance of this Agreement will not infringe the rights of any third party or cause it to be in breach of any obligations to a third party.</td>
                <td style="direction: rtl;">
                    ٥.١	. يتعهد كل من الطرفين ويضمنان ويقران للطرف الآخر بما أ/امتلاك كل الصلاحيات والأهلية للدخول في هذه الاتفاقية واتخاذ جميع الاجراءات اللازمة لإبرام هذه الاتفاقية وتنفيذها ومنح الحقوق الواردة فيها، و ب/ الدخول في هذه الاتفاقية وتنفيذها لا ينتهك حقوق الغير أو يسبب انتهاك لأي التزامات تجاه الغير.
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #000; border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">٥.2. The First party undertakes to the Second party and guarantees that all services will be of high quality and will be implemented with perfection, in a timely manner,
                and with professional skill in accordance with the terms of the annex or the purchase order and the specifications therein.</td>
                <td style="direction: rtl;">
                    ٥.٢. يتعهد الطرف الأول للطرف الثاني ويضمن بأن جميع الخدمات ستكون ذات جودة عالية وسيتم تنفيذها بإتقان وفي الوقت المناسب، وبمهارة احترافية وفقا لشروط الملحق أو أمر الشراء والمواصفات فيه.
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;"><br><h4>6. LIMITATION OF LIABILITY</h4></td>
                <td style="direction: rtl;">
                    <br><h4>
                        ٦. حد المسؤولية
                    </h4>
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">6.1. Nothing in this Agreement shall limit or exclude any party's liability for: a) for fraud, including fraud, committed by such party;
                (b) for death or personal injury caused by such party's negligence; c) for the liability mentioned in Clause (4); or
                d) for any other liability that may not be limited or excluded under applicable law.</td>
                <td style="direction: rtl;">
                    ٦.١. لا يوجد في هذه الاتفاقية ما من شأنه أن يحد أو يعف مسؤولية أي طرف: ا) عن الاحتيال، بما في ذلك التدليس، الذي يرتكبه هذا الطرف؛ )ب) عن الوفاة أو الإصابة الشخصية الناجمة عن الإهمال من جانب هذا الطرف؛ ج) عن المسؤولية المذكورة في البند (٤)؛ أو د) عن أي مسؤولية أخرى لا يجوز حدها أو الإعفاء منها بموجب القانون المعمول به.
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">6.2. Subject to Clause 6.1, in no event will either party or affiliate companies be liable or indirect, incidental,
                punitive or consequential damages to the other party or companies</td>
                <td style="direction: rtl;">
                    ٦.٢. مع مراعاة البند ٦-١، لن يتحمل أي من الطرفين أو الشركات التابعة في أي حال من الأحوال المسؤولية أو الأضرار الغير مباشرة أو العرضية أو التأديبية أو التبعية تجاه الطرف الآخر أو الشركات
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #000; border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">affiliated party for whatever reason arising out of or relating to this contract, even if such party has been advised of the possibility of such damages.
                The foregoing will apply regardless of negligence or tort of any party and regardless of whether it arises from contract, tort, negligence or any other theory of liability.
                In no event shall the Second Party Company be liable to the Company or any third party (whether the liability arises from contract, tort, negligence or any other theory of liability)
                in an amount greater than the aggregate amounts paid by the Second Party set forth in the Appendix related to.</td>
                <td style="direction: rtl;">
                    التابعة له مهما كان سببها التي قد تنشأ أو تتعلق بهذا العقد، حتى إذا تم إخطار هذا الطرف إمكانية حدوث هذه الأضرار. سيطبق ما سبق بغض النظر عن الإهمال أو أي ضرر من جانب أي طرف وبغض النظر عما إذا كانت ناشئة من عقد أو ضرر أو إهمال أو أي نظرية أخرى تتعلق بالمسؤولية. لن تكون شركة الطرف الثاني   مسؤولة في أي حال من الأحوال تجاه الشركة أو أي طرف ثالث (سواء كانت المسؤولية ناشئة من عقد أو ضرر أو إهمال أو أي نظرية أخرى تتعلق بالمسؤولية) بمبلغ أكبر من المبالغ الإجمالية التي دفعت من قبل الطرف الثاني المنصوصة/في الملحق ذات الصلة.
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;"><br><h4>7. TERM AND TERMINATION</h4></td>
                <td style="direction: rtl;">
                    <br><h4>
                        ٧. مدة الاتفاقية وإنهائها
                    </h4>
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">7.1. This Agreement shall be effective as of the Effective Date and shall continue in effect and this Agreement shall terminate upon the expiration of the agreed term,
                unless it is previously terminated as provided herein, provided that in the event of an incomplete supplement or purchase order executed at the time of termination of this Agreement,
                this Agreement shall remain in force Until all services to be provided hereunder have been accepted by the Second Party Company</td>
                <td style="direction: rtl;">
                    ٧.١. تسري هذه الاتفاقية اعتباراً من تاريخ السريان وتستمر سارية المفعول وتنتهي هذه الاتفاقية بانتهاء المدة المتفق عليها، ما لم يتم إنهاؤها مسبقاً كما هو منصوص عليه هنا، بشرط أنه في حالة وجود ملحق أو أمر شراء غير مكتمل تنفيذه وقت انتهاء هذه الاتفاقية، ستظل هذه الاتفاقية سارية حتى يتم قبول جميع الخدمات التي سيتم تقديمها بموجبه من قبل شركة الطرف الثاني
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">7.2. The Second Party may terminate this Agreement or any individual supplement or purchase order at any time by giving written notice to the Company within thirty (30) days from the intended date of termination.
                After the effective date of the expiration of the agreement, (a) the company will not be obligated to continue the implementation of the terminated services,
                (b) the Second party will pay the fees to the company for all services that were implemented before the effective date of the expiry of the agreement,
                (c) no obligation or responsibility arises for any party of the parties to the other (including, without limitation, expected revenue, profit, or any costs or expenses incurred under this Agreement) that may arise from the termination of Services.</td>
                <td style="direction: rtl;">
                    ٧.٢. يجوز للطرف الثاني إنهاء هذه الاتفاقية أو أي ملحق فردي أو أمر شراء في أي وقت وذلك بتوجيه إشعار خطي للشركة مدته ثلاثين (٣٠) يوما من التاريخ المزمع للإنهاء. وبعد تاريخ سريان انتهاء الاتفاقية، (أ) لن تكون الشركة ملزمة بالإستمرار في تنفيذ الخدمات المنتهية، (ب) سيقوم الطرف الثاني  بدفع الرسوم للشركة لجميع الخدمات التي تم تنفيذها قبل تاریخ سريان انتهاء الاتفاقية، (ج) لا يترتب أي إلتزام أو مسؤولية لأي طرف من الطرفين تجاه الآخر (بما في ذلك، على سبيل المثال لا الحصر، الإيرادات المتوقعة، أو الأرباح ، أو أي تكاليف أو مصاريف متكبدة بموجب هذه الاتفاقية) التي قد تنشأ من انهاء الخدمات.
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">7.3. Either party may terminate this Agreement or any individual addendum immediately upon the other party's breach of this Agreement,
                provided that: (a) the non-breaching party gives written notice to the breaching party describing the details of the breach;
                (b) the defaulting party does not remedy the breach within fifteen (15) days; (c) After the expiration of the fifteen
                (15) day period, the non-defaulting party shall send a First written notice to the defaulting party, indicating the non-defaulting party's election to terminate this Agreement.
                In the event of any reasoned termination by the First party, there will be no other payment or performance obligations to Bandar Trading Company (one person company) under this agreement.</td>
                <td style="direction: rtl;">
                    ٧.٣ يجوز لأي طرف من الطرفين انهاء هذه الاتفاقية أو أي ملحق فردي فور اخلال الطرف الآخر لهذه الاتفاقية، شريطة أن: (أ) يقوم الطرف غير المخالف بتوجيه اشعار خطي للطرف المخالف يصف فيه تفاصيل الإخلال؛ (ب) لم يقم الطرف المخل بمعالجة الإخلال في غضون خمسة عشر (١٥) يوما؛ (ج) وبعد انقضاء فترة الخمسة عشر (١٥) يوما يقوم الطرف غير المخل بإرسال إخطار خطي ثان للطرف المخل، مشيراً إلى اختيار الطرف غير المخل لإنهاء هذه الاتفاقية. في حالة أي انهاء مسبب من قبل الطرف الأول  ،  لن يكون هناك أي التزامات دفع أو أداء أخرى لشركة بندر التجارية (شركة شخص واحد) بموجب هذه الاتفاقية.
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #000; border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">7.4. A party to a party may, on its part, perform such portfolio, or re-create, or re-merge, or re-merge, or re-create, such party. Graduating in the event of a warning of readiness,
                stopping or threatening to stop business or not being able to pay debts when they are due.</td>
                <td style="direction: rtl;">
                    ٧.٤. يجوز لأي طرف من الطرفين انهاء هذه الاتفاقية بأثر فوري بتوجيه اشعار خطي للطرف الآخر الذي يكون تحت الحراسة القضائيةحيث يتم تعيين حارس قضائي على كامل أو أي جزء من تعهدات هذا الطرف، اصدار قرار تصفية بخلاف الاندماج أو اعادة البناء، اذا كان هذا الطرف خاضع لأمر إداري، الدخول في ترتيبات طوعية مع الدائنين، التوقف أو التهديد بتوقيف الأعمال التجارية أو عدم القدرة على سداد الديون عند استحقاقها.
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;"><h4>8. GENERAL</h4></td>
                <td style="direction: rtl;">
                    <h4>
                        ٨. أحكام عامة
                    </h4>
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">8.1. Notices. Any notice which either party is required or authorised by this Agreement to give or make to the other shall be given in writing by email (to the email address provided),
                post or hand delivery addressed to the other party at their last known business address.</td>
                <td style="direction: rtl;">
                    ٨.١. الاخطارات: يجب أن تحرر أي مراسلات مقدمة بموجب هذا العقد خطياً، وترسل عن طريق البريد الإلكتروني، أو تسلم باليد، أو بواسطة البريد على عنوان الطرف الآخر.
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">8.2. Insurance and Force Majeure. Company will maintain sufficient insurance coverage to enable it to meet its obligations created by this Agreement and by law. Notwithstanding anything else contained in this Agreement neither party shall be liable for any delay in performing its obligations if such delay is caused by a force majeure event.</td>
                <td style="direction: rtl;">
                    ٨.٢. التأمين والقوة القاهرة يجب على الشركة الحصول على تغطية تأمينية كافية لتمكينها من الوفاء بالتزاماتها الناشئة عن هذه الاتفاقية وعن القانون. لا يعتبر أي من الطرفين مسؤولاً عن أي تأخير في التزاماته اذا كان التأخير ناجما من حدوث قوة قاهرة.
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">8.3 Agents, Subcontractors, and Relationship of the Parties: Neither party may appoint any agents or subcontractors to perform its obligations under this Agreement, or assign, delegate or deal with its obligations under this Agreement, without the prior written consent of the other party, and it will be the First party Responsible for any actions or failures by the subcontractors as if they were the actions and failures of the Second party in relation to the services it provides under this agreement and mentioned in the purchase order in the appendix, and nothing in this agreement is interpreted or considered as creating a relationship between an employer and an employee or Partnership, agency, joint venture or joint venture.</td>
                <td style="direction: rtl;">
                    ٨.٣ الوكلاء والمقاولين من الباطن وعلاقة الأطراف: لا يجوز لكلا الأطراف  تعيين أي وكلاء أو مقاولين من الباطن لأداء التزاماتها بموجب هذه الاتفاقية، أو تنازل أو تفويض أو التعامل مع التزاماتها بموجب هذه الاتفاقية، دون موافقة خطية مسبقة من الطرف الاخر ، وستكون الطرف الأول مسؤولة عن أي أفعال أو إخفاقات من قبل المقاولين من الباطن كما لو كانت أفعال واخفاقات الطرف الثاني في ما يتعلق بالخدمات التي يقدمها بموجب هذه الاتفاقية والمذكورة في امر الشراء بالملحق ، ولا يوجد في هذه الاتفاقية ما يفسر أو يعتبر أنها إنشاء علاقة بين صاحب عمل وموظف أو شراكة أو وكالة أو مشروع مشترك أو شركة مشتركة.
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">8.4 Governing Law and Jurisdiction. This Agreement shall be governed by and construed in accordance with the laws of KSA. Both parties irrevocably submit to the exclusive jurisdiction of the courts of KSA.</td>
                <td style="direction: rtl;">
                    ٨.٤. القانون المطبق والاختصاص القضائي تخضع هذه الاتفاقية للقوانين المطبقة في المملكة العربية السعودية وتفسر وفقاً لهذه القوانين. ويوافق الطرفان موافقة نهائية على الخضوع للاختصاص القضائي الحصري لمحاكم المملكة العربية السعودية.
                </td>
            </tr>
            <tr style="border-bottom: 1px solid #000; border-right: 1px solid #000; border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">8.5 Assignment, Counterparts and Entire Agreement. This Agreement may not be assigned by either party without the prior written consent of the other party. This Agreement may be executed in any number of counterparts, and by the parties in separate counterparts, which together constitute one single agreement between the parties. This Agreement executed pursuant hereto contain the entire agreement between the parties with respect to the subject matter hereof and supersede all oral understandings, representations, prior discussions and preliminary agreements.</td>
                <td style="direction: rtl;">
                    ٨.٥. التنازل والنسخ ومجمل الاتفاقية لا يجوز التنازل عن هذه الاتفاقية من قبل أي طرف دون الحصول على موافقة خطية مسبقة من الطرف الآخر. وحررت هذه الاتفاقية من عدة نسخ من قبل الأطراف وفي نسخ منفصلة التي تشكل معا اتفاقية واحدة بين الأطراف. وقد استلم كل طرف نسخة منها للعمل بموجبها. تحتوي هذه الاتفاقية على مجمل الاتفاق بين الأطراف فيما
                    <br>
                    يخص موضوعها، وتلغي كل الاتفاقيات المبدئية، والمناقشات والإقرارات سواء خطية أو شفهية فيما يتعلق بموضوعها.
                </td>
            </tr>
        </table>
            </div>
        @elseif($row[0]->contractType == 2)
            <div class="table-responsive">
                <table class="table" style="text-align: justify; border-collapse: collapse;">
                <tr style="border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000">
                    <td style="border-right: 1px solid #000;"><b>THIS MANPOWER SERVICES AGREEMENT is made on {{$row[0]->cont_start_date}} between:</b></td>
                    <td style="direction: rtl;"><b>أبرمت اتفاقية خدمات العمالة هذه بتاريخ {{$row[0]->cont_start_date}} بین کلاً :</b></td>
                </tr>
                <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                    <td style="border-right: 1px solid #000;"><br><b>1 Company: {{$company}}</b> in {{$row[0]->national_address_en}}<br> C. R. No. {{$row[0]->reg_number}} <br>
                    VAT Registration No. {{$row[0]->vat_certificate_number}}<br>E-mail. {{$row[0]->companyEmail}}<br> represented herein by {{$row[0]->info_person_name}} hereinafter referred to as the (the Second Party).
                    </td>
                    <td style="direction: rtl;"><br><b>شركة:{{$row[0]->companyName_ar}}</b> وعنوانها: {{$row[0]->national_address_ar}}
                    <br>سجل رقم :{{$row[0]->reg_number}}
                    <br>    الرقم الضريبي : {{$row[0]->vat_certificate_number}}
                    <br>    البريد الالكتروني :     {{$row[0]->companyEmail}}
                    <br>    ويمثلها / السيد : {{$row[0]->info_person_name_ar}}  ويشار إليها في هذا العقد بـ
                        (الطرف الثاني)
                    </td>
                </tr>
                <tr style="border-right: 1px solid #000; border-left: 1px solid #000; border-bottom: 1px solid #000">
                    <td style="border-right: 1px solid #000;"><b>2 Company: Bandar Trading Company: - for Logistics</b>.<br><br>
                    C.R.Number: 1010607540<br>
                    VAT Registration No: 310462974800003 <br>
                    E-mail. cpm@btclogistic.com<br>
                    represented herein by Bandar Trading Company in RIYADH referred to as the (the First Party).
                    </td>
                    <td style="direction: rtl;"><b>
                         شركة / بندر التجارية ( شركة شخص واحد ) وعنوانها الرياض – النرجس </b>
                        <br> سجل رقم : 1010607540
                        <br>ورقم تسجيلها الضريبي: 310462974800003
                        <br>البريد الالكتروني :  cpm@btclogistic.com
                        <br>  ويمثلها / السيد....بندر منصور ال عامر   ويشار إليها في هذا العقد بـ
                            (الطرف الأول)
                    </td>
                </tr>
                <tr style="border-right: 1px solid #000; border-left: 1px solid #000; border-bottom: 1px solid #000">
                    <td style="border-right: 1px solid #000;">
                        1. The first party offers its electronic products to its customers (clients) via the commercial platform licensed by the relevant authorities and desires to obtain business solutions, technical solutions, transportation solutions, and logistical services.<br>
                        Whereas the second party has transportation and logistics solutions, is licensed by the relevant authorities, and operates stores for the first party (services).<br>
                        2.3. Where both parties, while in a total legal capacity, wish to enter into undertakings. and the obligations of this agreement) between them to implement the service in accordance with the following provisions
                    </td>
                    <td style="direction: rtl;">
                        <b>التمهيد والتعريف </b>
                        <br>1.	حيث يقدم الطرف الأول منتجاته الالكترونية لعملائه ( العملاء ) عبر منصة التجارية المرخصة من قبل الجهات المعنية  ويرغب في الحصول على حلول أعمال وحلول تقنية وحلول نقل وخدمات لوجستية
                        <br>وحيث ان الطرف الثاني لدية حلول النقل والخدمات اللوجستية ومرخص من قبل الجهات المعنية وتشغيل المتاجر للطرف الأول ( الخدمات )
                        <br>2.3. وحيث  يرغب الطرفان , وهما بكامل الأهلية النظامية الدخول في تعهدات . والتزامات هذه الاتفاقية ) بينهما لتنفيذ الخدمة وفقاً للبنود التالية
                    </td>
                </tr>
                <tr style="border-right: 1px solid #000; border-left: 1px solid #000; border-bottom: 1px solid #000">
                    <td style="border-right: 1px solid #000;">
                        The first item is parts of the agreement.
                        <br>1. The previous preamble and the appendices to this agreement are considered an integral part of this agreement, and complement each of its clauses, as the contract is read and interpreted along with it.
                        <br>2. If any of the previous parts conflict, the later date prevails.
                    </td>
                    <td style="direction: rtl;">
                        <b>البند الأول : أجزاء الاتفاقية .</b>
                        <br>1.	يعتبر التمهيد السابق وملاحق هذه الاتفاقية جزءًا لا يتجزأ من هذه الاتفاقية , وتكمل كل بند من بنودها حيث تقرأ الاتفاقية وتفسّر معها .
                        <br>2.	في حال تعارض أي من الأجزاء السابقة فإن المتأخر تاريخًا يسود ماقبله .
                    </td>
                </tr>
                <tr style="border-right: 1px solid #000; border-left: 1px solid #000; border-bottom: 1px solid #000">
                    <td style="border-right: 1px solid #000;">
                        The second item is securing authorization, licenses, and all powers.
                        <br>1. Each party must secure all licenses, powers, and authorization necessary from all responsible parties to implement its obligations in providing the service, or using it, under the regulations in the Kingdom of Saudi Arabia, and each party is solely and individually responsible for this insurance and the consequences that arise from it.
                    </td>
                    <td style="direction: rtl;">
                        <b>البند الثاني : تأمين التفويض والرخص وكافة الصلاحيات .</b>
                        <br>1.	يجب على كل طرف تأمين كافة الرخص , والصلاحيات والتفويض اللازم من كافة الجهات المسؤولة لتنفيذ التزاماته في تقديم الخدمة , أو استخدامها , وفقًا للأنظمة في المملكة العربية السعودية , ويعد كل طرف وحده مسؤولاً وبانفراد عن هذا التأمين , وما يترتب عليه من عواقب .
                    </td>
                </tr>
                <tr style="border-right: 1px solid #000; border-left: 1px solid #000; border-bottom: 1px solid #000">
                    <td style="border-right: 1px solid #000;">
                        The third item is the scope of the agreement and determining the responsibilities for its implementation.
                        <br>1. The second party provides agreed-upon shipping services in the application market and to electronic stores according to the level of service that the two parties agree upon later.
                    </td>
                    <td style="direction: rtl;">
                        <b>البند الثالث : نطاق الاتفاقية وتحديد مسؤوليات تنفيذها .</b>
                        <br>1.	يقدّم الطرف الثاني خدمات الشحن المتفق عليها في سوق التطبيقات , وللمتاجر الالكترونية  وفق مستوى الخدمة التي يتفق عليها الطرفان لاحقا.
                    </td>
                </tr>
                <tr style="border-right: 1px solid #000; border-left: 1px solid #000; border-bottom: 1px solid #000">
                    <td style="border-right: 1px solid #000;">
                        Fourth item: Responsibility for all data and its protection.
                        <br>For the purpose of providing service to customers in accordance with best practices, procedures may require all data for the purpose of carrying out operations on the application market (data) according to the following:
                        <br>1. The second party is committed to protecting customer data from disclosure and use for purposes other than providing the service.
                        <br>2. Both parties are committed not to disclosing this data without the customer’s consent.
                        <br>3. The two parties may disclose this data at the request of the regulatory authorities in the Kingdom of Saudi Arabia while notifying the customers and the other party of this agreement request.
                    </td>
                    <td style="direction: rtl;">
                        <b>البند الرابع : المسؤولية عن جميع البيانات وحمايتها .</b>
                        <br>لغرض تقديم الخدمة للعملاء وفقًا لأفضل الممارسات فإن الإجراءات قد تقتضي جميع البيانات لغرض تنفيذ العلميات على سوق التطبيقات ( البيانات ) وفقًا لما يلي :
                        <br>1.	يلتزم الطرف الثاني بحماية بيانات العملاء من الإفشاء والاستخدام لغير أغراض تقديم الخدمة .
                        <br>2.	يلتزم الطرفان بعدم إفشاء هذه البيانات دون موافقة العملاء .
                        <br>3.	يجوز للطرفين الكشف عن هذه البيانات تحت طلب السلطات النظامية في المملكة العربية السعودية مع إشعار العملاء ’ والطرف الآخر في هذه الاتفاقية بهذا الطلب .
                    </td>
                </tr>
                <tr style="border-right: 1px solid #000; border-left: 1px solid #000; border-bottom: 1px solid #000">
                    <td style="border-right: 1px solid #000;">
                        Clause Five: Financial Provisions.
                        <br>1-5 The first party will pay the fees mentioned in the purchase order to the second party under this clause (5) to implement the services on time and with professional quality.
                        <br>2-5 Invoices are submitted to the first party as indicated in the relevant purchase order. The undisputed due amounts will be paid by the first party to the second party within (7) days after receiving the invoice(s) and verifying their authenticity.

                    </td>
                    <td style="direction: rtl;">
                        <b>البند الخامس : الأحكام الماليّة .</b>
                        <br>1-5 سوف يقوم الطرف الأول  بدفع الرسوم المذكورة في أمر الشراء للطرف الثاني بموجب هذا البند (5) لتنفيذ الخدمات في التوقيت الملائم وبالجودة المهنية.
                        <br>2-5  يتم تقديم الفواتير إلى الطرف الأول  كما هو مبين في أمر الشراء ذي الصلة. وسيتم سداد المبالغ المستحقة غير المتنازع عليها من قبل الطرف الأول للطرف الثاني  خلال (٧) يوم بعد استلام الفاتورة/الفواتير والتحقق من صحتها .
                    </td>
                </tr>
                <tr style="border-right: 1px solid #000; border-left: 1px solid #000; border-bottom: 1px solid #000">
                    <td style="border-right: 1px solid #000;">
                        Article Six: Penal conditions, delay fine.
                        <br>If the second party is unjustifiably delayed in providing any of the services or tasks outlined in this agreement at the time specified for it, the following shall result:
                        <br>First: A written warning to correct the situation within (24) hours of notifying the second party of the problem.
                        <br>Second: If the second party does not respond to the first paragraph, the first party has the right to stop the second party’s services from delivering its products for (72) hours after notifying it in writing.
                    </td>
                    <td style="direction: rtl;">
                        <b>البند السادس: الشروط الجزائية، غرامة التأخير.</b>
                        <br>في حال تأخر الطرف الثاني على نحو غير مبرر في تقديم أي من الخدمات، او المهام المبينة في هذه الاتفاقية في الوقت المحدد لها، فيترتب عليه الآتي:
                        <br>أولاً: إنذار كتابي بتصحيح الأوضاع خلال (24) ساعة من تبليغ الطرف الثاني بالمشكلة.
                        <br>ثانيا: في حال عدم تجاوب الطرف الثاني مع الفقرة الأولى، فيحق للطرف الأول إيقاف خدمات الطرف الثاني  عن توصيل منتجاته لمدة (72) ساعة وذلك بعد إشعاره كتابيا
                    </td>
                </tr>
                <tr style="border-right: 1px solid #000; border-left: 1px solid #000; border-bottom: 1px solid #000">
                    <td style="border-right: 1px solid #000;">
                        Clause Seven: Amendment to the Agreement.
                        <br>No change, amendment, or improvement may be made to this Agreement except by a written document signed by the representatives of this Agreement for each party, which shall be added to it as an annex. These amendments shall be effective immediately upon their signing by the two parties unless the two parties agree to specify a different period for entry into force. those modifications.
                    </td>
                    <td style="direction: rtl;">
                        <b>البند السابع: التعديل على الاتفاقية.</b>
                        <br>لا يجوز إجراء أي تغيير أو تعديل أو تحسين في هذه الاتفاقية إلا بموجب وثيقة مكتوبة وموقعة من الممثلين في هذه الاتفاقية عن كل طرف، تضاف اليها كمُلحق، وتكون هذه التعديلات سارية النفاذ فور توقيع الطرفين عليها، إلا اذا اتفق الطرفان على تحديد مدة مغايرة لسريان نفاذ تلك التعديلات.
                    </td>
                </tr>
                <tr style="border-right: 1px solid #000; border-left: 1px solid #000; border-bottom: 1px solid #000">
                    <td style="border-right: 1px solid #000;">
                        Clause Eight: Duration of the Agreement.
                        <br>1. The term of this Agreement shall begin on the date of:
                        {{$row[0]->cont_start_date}} AD and expires on {{$row[0]->cont_end_date}} and is renewed automatically unless one of the other parties is informed of its unwillingness to renew before (30) days.
                        <br>2. The second party may terminate this agreement at any time, provided that the other party is notified (30) days before the expiration date.

                    </td>
                    <td style="direction: rtl;">
                        <b>البند الثامن: مدة الاتفاقية.</b>
                        <br>1.	تبدأ مدة هذه الاتفاقية من تاريخ:
                        <br>{{$row[0]->cont_start_date}}م وتنتهي بتاريخ {{$row[0]->cont_end_date}} ويتم التجديد تلقائيا ما لم يتم إبلاغ أحد الأطراف الآخر بعدم الرغبة في التجديد قبل (٣٠) يوم.
                        <br>2.	يجوز للطرف الثاني  إنهاء هذه الاتفاقية في أي وقت بشرط إشعار الطرف الآخر ب (٣٠) يوم قبل تاريخ الانتهاء.

                    </td>
                </tr>
                <tr style="border-right: 1px solid #000; border-left: 1px solid #000; border-bottom: 1px solid #000">
                    <td style="border-right: 1px solid #000;">
                        Article Nine: The law governing the agreement.
                        <br>This agreement is subject to the laws of the Kingdom of Saudi Arabia, and any dispute between the two parties that is not resolved amicably shall be referred to the competent courts in the city of Riyadh, Kingdom of Saudi Arabia.
                    </td>
                    <td style="direction: rtl;">
                        <b>البند التاسع: القانون الحاكم للاتفاقية.</b>
                        <br> تخضع هذه الاتفاقية لأنظمة المملكة العربية السعودية، وأي خلاف بين الطرفين لم يحل وديا يحال إلى المحاكم المختصة في مدينة الرياض، المملكة العربية السعودية.
                    </td>
                </tr>
                <tr style="border-right: 1px solid #000; border-left: 1px solid #000; border-bottom: 1px solid #000">
                    <td style="border-right: 1px solid #000;">
                        Article Ten: The dominant language:
                        <br>This agreement was written in Arabic and English to be synonymous. In the event of a conflict between the two texts, the text in Arabic shall prevail.
                    </td>
                    <td style="direction: rtl;">
                        <b>البند العاشر: اللغة السّائدة:</b>
                        <br>كتبت هذه الاتفاقية باللغتين العربية والانجليزية بقصد الترادف، وفي حال التعارض بين النصين فإن النصّ باللغة العربية يسود.
                    </td>
                </tr>
            </table>
            </div>
        @endif
        <br>
        <div class="table-responsive">
            <table class="table" style="border-collapse: collapse; width: 100%;">
            <thead>
                <th style="border: 1px solid black;">ANNEXURE NO. 1</th>
                <TH style="border: 1px solid black;">ملحق رقم [١]</TH>
            </thead>
            <tbody style="text-align: justify;">
                <tr>
                    <td style="border: 1px solid black; padding: 15px;">This Annexure No. 1 made on {{$row[0]->cont_start_date}}.</td>
                    <td style="border: 1px solid black; padding: 15px;direction: rtl">تم ابرام هذا الملحق رقم (١) في تاريخ {{$row[0]->cont_start_date}}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 15px;">This supplement includes and is subject to the Employment Services Agreement between both parties dated {{$row[0]->cont_start_date}} and clarifies the specific terms and conditions related to the provision of services as described in This supplement.</td>
                    <td style="border: 1px solid black; padding: 15px;direction: rtl">يتضمن هذا الملحق ويخضع لاتفاقية خدمات العمالة بين كلا الأطراف  بتاريخ {{$row[0]->cont_start_date}}ويوضح البنود والشروط المحددة المتعلقة بتقديم الخدمات كما هو موضح في   هذا الملحق.</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 15px;">Subject to an accompanying Purchase Order, Company agrees to provide the Services as set out in this Annexure</td>
                    <td style="border: 1px solid black; padding: 15px;direction: rtl">مع مراعاة أمر الشراء، قد وافقت الشركة على تقديم الخدمات كما هو مبين في هذا الملحق</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 15px;">1-Services: Support Services</td>
                    <td style="border: 1px solid black; padding: 15px;direction: rtl">١. الخدمات خدمات اعمال المساندة</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 15px;">2-Liquidated Damages: Not Applicable</td>
                    <td style="border: 1px solid black; padding: 15px;direction: rtl">٢- التعويض عن الأضرار: لا ينطبق</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 15px;">
                        <div class="table-responsive">
                            <table class="table" style="border-collapse: collapse; border: 1px solid black;">
                                <thead>
                                    <th style="border: 1px solid black;">Item</th>
                                    <th style="border: 1px solid black;">Description</th>
                                    <th style="border: 1px solid black;">Price</th>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td style="border: 1px solid black;">{{$item->name}}</td>
                                            <td style="border: 1px solid black;">{{$item->description}}</td>
                                            <td style="border: 1px solid black;">{{$item->price}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td style="border: 1px solid black; padding: 15px; direction: rtl">
                        <div class="table-responsive">
                            <table class="table" style="border-collapse: collapse; border: 1px solid black;">
                                <thead>
                                    <th style="border: 1px solid black;">الصنف</th>
                                    <th style="border: 1px solid black;">الوصف</th>
                                    <th style="border: 1px solid black;">السعر</th>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td style="border: 1px solid black;">{{$item->name_ar}}</td>
                                            <td style="border: 1px solid black;">{{$item->description_ar}}</td>
                                            <td style="border: 1px solid black;">{{$item->price}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr style="display: none">
                    <td style="border: 1px solid black; padding: 15px;">3-Fees (Excluding VAT).
                        <div class="table-container">
                            <div class="table-row">
                                <div class="table-cell table-header" style="flex-basis: 15%;">Item</div>
                                <div class="table-cell table-header" style="flex-basis: 75%;">Description</div>
                                <div style="display: none" class="table-cell table-header">Type</div>
                                @if($row[0]->contractType == 1)
                                <div style="display: none" class="table-cell table-header">Vehicle</div>
                                <div style="display: none" class="table-cell table-header">Quantity</div>
                                @endif
                                <div class="table-cell table-header" style="flex-basis: 10%;">Price</div>
                                @if($row[0]->contractType == 1)
                                    <div style="display: none" class="table-cell table-header">Per Day</div>
                                    <div style="display: none" class="table-cell table-header">Calculation</div>
                                @endif
                            </div>

                            @foreach($items as $item)
                                <div class="table-row">
                                    <div class="table-cell" style="flex-basis: 15%;">{{$item->name}}</div>
                                    <div class="table-cell" style="flex-basis: 75%;">{{$item->description}}</div>
                                    @if($row[0]->contractType == 1)
                                        <div style="display: none" class="table-cell">@if($item->type == 1) Monthly Salary @else Per Shipment @endif</div>
                                        <div style="display: none" class="table-cell">
                                            @if($item->type == 1)
                                                @if($item->vehicle_info_check == 1)
                                                    N/A
                                                @else
                                                    {{$item->vehicle_info}}
                                                @endif
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                        <div style="display: none" class="table-cell">@if($item->type == 1) {{$item->quantity}} @else N/A @endif</div>
                                    @elseif($row[0]->contractType == 2)
                                        <div style="display: none" class="table-cell">Per Shipment</div>
                                    @endif
                                    <div class="table-cell" style="flex-basis: 10%;">{{$item->price}}</div>
                                    @if($row[0]->contractType == 1)
                                        <div style="display: none" class="table-cell">@if($item->type == 1) {{round($item->price / 26)}} @else N/A @endif</div>
                                        <div style="display: none" class="table-cell">@if($item->type == 1) {{$item->price}} / 26 @else N/A @endif</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </td>
                    <td style="border: 1px solid black; padding: 15px;direction: rtl">٣-  الرسوم ( غير شامل الضريبة)
                        <div class="table-container">
                            <div class="table-row">
                                <div class="table-cell table-header" style="flex-basis: 15%;">الصنف</div>
                                <div class="table-cell table-header" style="flex-basis: 75%;">الوصف</div>
                                <div style="display: none" class="table-cell table-header">يكتب</div>
                                @if($row[0]->contractType == 1)
                                    <div style="display: none" class="table-cell table-header">المركبة</div>
                                    <div style="display: none" class="table-cell table-header">الكمية</div>
                                @endif
                                <div class="table-cell table-header" style="flex-basis: 10%;">السعر</div>
                                @if($row[0]->contractType == 1)
                                    <div style="display: none" class="table-cell table-header">في اليوم</div>
                                    <div style="display: none" class="table-cell table-header">معادلة</div>
                                @endif
                            </div>

                            @foreach($items as $item)
                                <div  class="table-row">
                                    <div class="table-cell" style="flex-basis: 15%;">{{$item->name_ar}}</div>
                                    <div class="table-cell" style="flex-basis: 75%;">{{$item->description_ar}}</div>
                                    @if($row[0]->contractType == 1)
                                        <div style="display: none" class="table-cell">@if($item->type == 1)  شهري @else لكل شحنة @endif</div>
                                        <div style="display: none" class="table-cell">
                                            @if($item->type == 1)
                                                @if($item->vehicle_info_check == 1)
                                                    N/A
                                                @else
                                                    {{$item->vehicle_info_ar}}
                                                @endif
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                        <div style="display: none" class="table-cell">@if($item->type == 1) {{$item->quantity}} @else N/A @endif</div>
                                    @elseif($row[0]->contractType == 2)
                                        <div style="display: none" class="table-cell"> لكل شحنة </div>
                                    @endif
                                    <div class="table-cell" style="flex-basis: 10%;">{{$item->price}}</div>
                                    @if($row[0]->contractType == 1)
                                        <div style="display: none" class="table-cell">@if($item->type == 1) {{round($item->price / 26)}} @else N/A @endif</div>
                                        <div style="display: none" class="table-cell">@if($item->type == 1) 26 / {{$item->price}} @else N/A @endif</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 15px;">4-Payment Terms: 7 Days after Invoice submission.</td>
                    <td style="border: 1px solid black; padding: 15px;direction: rtl">٤- شروط الدفع: ٧ ايام من بعد استلام الفاتورة الشهرية</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 15px;">5-Effective Date: {{$row[0]->cont_start_date}}</td>
                    <td style="border: 1px solid black; padding: 15px;direction: rtl">٥- تاريخ السريان: {{$row[0]->cont_start_date}}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 15px;">6-Term : 1  Gregorian Year</td>
                    <td style="border: 1px solid black; padding: 15px;direction: rtl">٦- مدة هذا الملحق:  ١ سنة  ميلادية</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 15px;">The First party will notify the worker about basic information about the Second party's company and about the laws and regulations followed in the country. All employees who violate the policies and standards of the Second party are dismissed immediately. The kingdom Saudi Arabia, including but not limited to the residence permit and driving license in the event of a request to hire drivers.</td>
                    <td style="border: 1px solid black; padding: 15px;direction: rtl">يقوم الطرف الأول  بإخطار العامل بشأن المعلومات الأساسية بشأن شركة الطرف الثاني وبشأن الأنظمة والتشريعات المتبعة في الدولة جميع الموظفين المخالفين لسياسات ومعايير الطرف الثاني  يتم فصلهم على الفور ويوفر الطرف الأول بدلاء لهم و بالتأكد من توفر كافة الوثائق النظامية لدى الموظف وأنه مسموح له بالعمل بشكل نظامي في المملكةالعربية السعودية بما في ذلك على سبيل المثال لا الحصر رخصة الإقامة ورخصة القيادة في حال طلب توظيف سائقين.</td>
                </tr>
            </tbody>
        </table>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table" style="border-collapse: collapse; text-align: justify;">
            <tr style="border-right: 1px solid #000;border-left: 1px solid #000;border-top: 1px solid #000;">
                <td style="border-right: 1px solid #000;">The First party makes sure that their representative visits the police station or any government office to file the complaint and makes sure that what is necessary is done from the perspective of law and order. Law and order perspective.</td>
                <td style="direction: rtl;">
                    يقوم الطرف الأول بالتأكد من قيام ممثلهم بزيارة مركز الشرطة أو أي مكتب حكومي لتقديم الشكوى والتأكد من القيام بما يلزم من منظور القانون والنظام. منظور القانون والنظام.
                </td>
            </tr>
            <tr style="border-right: 1px solid #000;border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">For this purpose, the Second party will provide the relevant authorization letter to the representative of the First party to support the investigation of the case. The company will be responsible for all kinds of loss, theft and damage after receiving the shipment from the customer from the perspective of law and order. For this purpose, the Second party will provide the relevant authorization letter to the representative of the First party to support the investigation of the case. Both parties agree that details regarding the number of employees will be detailed in the relevant purchase order. Furthermore it
                </td>
                <td style="direction: rtl;">
                    ولهذا الغرض سيوفر الطرف الثاني خطاب التفويض ذي الصلة لممثل الطرف الأول لدعم التحقيق في القضية. سيكون الطرف الأول مسؤول عن جميع أنواع الخسائر والسرقة والأضرار بعد استلام الشحنة من العميل منظور القانون والنظام. ولهذا الغرض سيوفر الطرف الثاني خطاب التفويض ذي الصلة لممثل الطرف الأول لدعم التحقيق في القضية. يتفق الطرفان على أن التفاصيل المتعلقة بعدد الموظفين سيتم تفصيلها في أمر الشراء ذي الصلة. علاوة على ذلك ،
                </td>
            </tr>
            <tr style="border-right: 1px solid #000;border-left: 1px solid #000;">
                <td style="border-right: 1px solid #000;">
                    All working hours of the Public Authority for Housing Units were paid to the Second party by the First party, respectively. The First party is shipping. Or an official email stating that
                </td>
                <td style="direction: rtl;">
                    سيتم دفع جميع ساعات العمل الاضافية الموثقة وفقا لقوانين العمل المحلية للطرف الثاني ( الأول ) من قبل الطرف الأول( الثاني ) على أنه لن يتم تنفيذ أي خدمات من قبل الشركة دون أمر شراء متفق عليه. لن يكون الطرف الأول(الثاني ) مسؤولة عن أي رسوم يتم فيها تقديم الخدمة دون أمر شراء متفق عليه. او بايميل رسمي يوضح ذلك
                </td>
            </tr>
            <tr style="border-right: 1px solid #000;border-left: 1px solid #000; border-bottom: 1px solid #000;">
                <td style="border-right: 1px solid #000;"></td>
                <td style="direction: rtl;">
                    وقع الطرفان على هذا المستند بوصفه الملحق في التواريخ المبينة أدناه
                </td>
            </tr>

            <tr style="border-right: 1px solid #000;border-left: 1px solid #000;">
                <td>First Company : Bander Trading Company</td>
                <td style="direction: rtl;">
                    الطرف الأول : شركة بندر التجارية
                </td>
            </tr>
        </table>
        </div>
        <div style="margin-top: -17px; padding: 15px; border-left: 1px solid; border-right: 1px solid;">
            <div style="width: 50%;display: flex; float: left">
                <span class="by-margin">By:</span> <img class="img-width" src="/storage/CompanyQuotation/abu_naif_sign.png">
            </div>
            <div style="width: 50%;display: flex;direction: rtl;">
              <span class="by-margin">التوقيع:</span>
                 <img class="img-width" src="/storage/CompanyQuotation/abu_naif_sign.png">
            </div>
        </div>
        <div class="table-responsive">
            <table class="table" style="border-collapse: collapse; text-align: justify; width: 100%">
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td>Name : BANDER ALAMER</td>
                <td style="direction: rtl;">
                     الاسم : بندر العامر
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td>Title : General manager</td>
                <td style="direction: rtl;">
                    اللقب الوظيفي: مدير عام
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td>Signature date : {{ $row[0]->ceo_signature_date }}</td>
                <td style="direction: rtl;">
                     تاريخ التوقيع: {{ $row[0]->ceo_signature_date }}
                </td>
            </tr>

            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td><br><br>Second Company : {{ $row[0]->companyName }}</td>
                <td style="direction: rtl;"><br><br>
                     الطرف الثاني : {{ $row[0]->companyName_ar }}
                </td>
            </tr>
        </table>
        </div>
        <div style="margin-top: -17px; padding: 15px; border-left: 1px solid; border-right: 1px solid;">
            <div style="width: 50%;display: flex; float: left">
                <span class="by-margin">By:</span> <img class="img-width" src="/storage/CompanyQuotation/{{ $row[0]->eSignature }}">
            </div>
            <div style="width: 50%;display: flex;direction: rtl;">
              <span class="by-margin">التوقيع:</span>
                 <img class="img-width" src="/storage/CompanyQuotation/{{ $row[0]->eSignature }}">
            </div>

        </div>
        <div class="table-responsive">
            <table style="border-collapse: collapse; text-align: justify; width: 100%">
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td>Name : {{ $row[0]->info_person_name }}</td>
                <td style="direction: rtl;">
                     الاسم : {{ $row[0]->info_person_name_ar }}
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000;">
                <td>Title : {{$row[0]->info_person=='0'? 'Owner' : 'Authorized Person'}}</td>
                <td style="direction: rtl;">
                     اللقب الوظيفي : {{$row[0]->info_person=='0'? 'مالك' : 'الشخص المرخص'}}
                </td>
            </tr>
            <tr style="border-right: 1px solid #000; border-left: 1px solid #000; border-bottom: 1px solid #000;">
                <td>Signature date : {{ $row[0]->signature_date }}</td>
                <td style="direction: rtl;">
                     تاريخ التوقيع : {{ $row[0]->signature_date }}
                </td>
            </tr>
        </table>
        </div>
        <div class="bor-heigt" style="width: 100%;
            background-repeat: round;
            background-image: url('/storage/CompanyQuotation/cont_bk_img.jpg');
            page-break-before: always;

            ">
            <center><h1 class="padd-top">Signature Certificate</h1>
            <p>Reference Number: {{ $row[0]->ref_no }}</p></center>
            <div class="table-responsive">
                <table class="" style="width: 100%">
                <tr>
                    <th style="padding: 0; text-align: center">Bander Trading Company</th>
                    <th style="padding: 0; text-align: center">Signature</th>
                </tr>
                <tr>
                    <td style="padding: 0;text-align: center">
                        Email: manager@btclogistic.com <br>
                        Sent: {{ $row[0]->ceo_signature_date }} ATC <br>
                        Signed: {{ $row[0]->ceo_signature_date }} ATC <br>
                        <h3>Recipient Verification:</h3>
                        ✔Email verified: {{ $row[0]->ceo_signature_date }} ATC
                    </td>
                    <td style="padding: 0;text-align: center">
                        <img class="img-width" style="border: 1px solid;" src="/storage/CompanyQuotation/abu_naif_sign.png">
                        <p>IP address: {{ $row[0]->ceo_ip }} <br>
                        Location: {{ $row[0]->ceo_address }}</p>
                    </td>
                </tr>
                <tr>
                    <th style="padding: 0; text-align: center">{{$company}}</th>
                    <th style="padding: 0; text-align: center"></th>
                </tr>
                <tr>
                    <td style="padding: 0; text-align: center">
                        Email: {{ $row[0]->companyEmail }} <br>
                        Sent: {{ $row[0]->ceo_signature_date }} ATC  <br>
                        Viewed: {{ $row[0]->cont_view_date }} ATC  <br>
                        Signed: {{ $row[0]->signature_date }} ATC  <br>
                        <h3>Recipient Verification:</h3>
                        ✔Email verified: {{ $row[0]->cont_view_date }} ATC

                    </td>
                    <td style="padding: 0; text-align: center;">
                        <img class="img-width" style="border: 1px solid;" src="/storage/CompanyQuotation/{{ $row[0]->eSignature }}">
                        <p>IP address: {{ $row[0]->client_ip }} <br>
                        Location: {{ $row[0]->client_address }}</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 0; text-align: center">
                        Document completed by all parties on:<br>
                        {{ $row[0]->signature_date }} ATC</p>
                    </td>
                    <td style="padding: 0; text-align: center"><img class="qr_code" src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl={{url('')}}/verification/{{base64_encode($row[0]->id)}}%2F&choe=UTF-8" title="Link to Contract" /></td>
                </tr>

            </table>
            </div>
        </div>
        <div class="watermark"><img src="https://i.ibb.co/r3Gwy46/JRS5942zr-Lr-QH8-IRHtfc-HB3y-T8i-Oz-Qv06e-XVp31-A-removebg-preview.png"/></div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<script>
    function export_pdf(company) {
    var printableSection = document.getElementById("printableSection");
    var printWindow = window.open('', '', 'width=1000,height=1000');

    // Open a new window and write the printable content to it
    printWindow.document.open();
    printWindow.document.write('<html><head><title>' + company + ' Contract</title></head><body>');
    printWindow.document.write(printableSection.innerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();

    // Wait for the content to be fully loaded before printing
    printWindow.onload = function() {
        printWindow.print();
        // printWindow.close();
    };
}

</script>
