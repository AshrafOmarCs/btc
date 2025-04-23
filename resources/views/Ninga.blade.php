<!doctype html>
<html lang="ar">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        th{
            background-color: #cfe2ff30; border: 1px solid black;
            border: 1px solid !important;
        }
        td{
            background-color: #cfe2ff30; border: 1px solid black;
            border: 1px solid !important;
        }
    </style>
            <script type="text/javascript">
                function generateBarCode()
                {
                    var nric = $('#text').val();
                    var url = 'https://api.qrserver.com/v1/create-qr-code/?data=' + nric + '&amp;size=50x50';
                    $('#barcode').attr('src', url);
                }
            </script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>DA Contract</title>
  </head>
  <body style="direction: rtl;margin:0">

    <div style="width: 90%;
    margin: 0 auto;">
        <div class="row">
            <div class="col-4" style="text-align: right;">
                <br>
                <img style="width: 97px;
                margin: 0 auto;
                margin-top: 2px;
                margin-bottom: 19px;" src="https://btclogistic.com/assets/icons/ICONS-07.png" alt="" srcset="">
                <h6 style="margin: 0;font-size: 18px;">شركة بندر التجارية(شركة شخص واحد)</h6>
                <h6 style="font-size: 18px;">الرقم المرجعي: <span ><span style="text-decoration: underline;">{{$drivers[0]->reference_no}}</span></span></h6>
            </div>
            <div class="col-4" style="text-align: center;">
                <br>
               <h4 style="text-decoration: underline;
               margin-top: 26px;
               font-size: 26px;color: #b3a958;"> عقد عمل  </h4>
            </div>
            <div class="col-4" style="text-align: left;direction: ltr;">
                <img style="margin: 0 auto;
                margin-top: 39px;" id='barcode' src="https://api.qrserver.com/v1/create-qr-code/?data= {{'https://btcdmins.com/DA-Conctrats/'.$drivers[0]->reference_no}} &amp;size=110x110"  alt=""  title="https://www.google.com/" />
                <br>
                <span># <span style="font-weight: bold">{{$drivers[0]->reference_no}}</span></span>

                <br>

            </div>
        </div>
        <div class="row">
            <div class="col-12" style="text-align: right;">
                <br>
               <h6> تم بحمد الله الاتفاق بين كل من:</h6>
            </div>
        </div>

        <div class="row">
            <div class="col-12" style="text-align: right;">
                <br>
               <h6 style="text-decoration: underline;    font-size: 18px;">  الطرف الأول:</h6>
            </div>
            <div class="col-12" style="text-align: right;">
                <br>
               <h6> شركة بندر التجارية(شركة شخص واحد) سجل تجاري رقم: <span style="font-weight: bold;text-decoration: underline;">1010607540</span>, وعنوانها الرئيسي مدينة الرياض طريق انس بن مالك - حي النرجس- ويمثلها بهذا العقد الأستاذ/بندر منصور ال عامر بصفته <span  style="font-weight: bold;text-decoration: underline;">مدير عام</span>.</h6>
            </div>
        </div>

        <div class="row">
            <div class="col-12" style="text-align: right;">
                <br>
               <h6 style="text-decoration: underline;    font-size: 18px;">  الطرف الثاني:</h6>
            </div>
            <div class="col-12" style="text-align: right;">
                <table style="width: 100%; text-align: center; ">
                    <tr>
                        <th>الاسم</th>
                        <th>اقامة رقم </th>
                        <th> الجنسية </th>
                        <th>رقم الجوال</th>
                        <th>المدينة المشروع</th>
                    </tr>
                    <tr>
                        <td>{{$drivers[0]->driver_name}}</td>
                        <td>{{$drivers[0]->iqama}}</td>
                        <td>{{$drivers[0]->nationality}}</td>
                        <td>{{$drivers[0]->phone}}</td>
                        <td>{{$drivers[0]->work_area}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-12" style="text-align: right;">
                <hr>
                <h6> على انا ويقوم الطرف الثاني بتوصيل الطلبات اعتباراً من تاريخ توقيع هذا العقد ولمدة سنة ميلادية قابلة للتجديد بالشروط التالية: </h6>
            </div>

            <div class="col-12" style="text-align: right;">
                <hr>
                <ul style="    background-color: #e0e4f0ba;">
                    <li style="font-size: 18px;">شروط عامة:</li>
                </ul>
             </div>
             <div class="col-12" style="text-align: right;">
                <ol>
                    <li> ان يوفر الطرف الثاني هوية + رخصه قياده +استمارة ساريه المفعول.</li>
                    <li>  الالتزام التام بحسن المظهر وبشروط الشركة اثناء العمل في التوصيل, والالتزام بالحضور والانصراف.</li>
                    <li> يخضع الطرف الثاني لفترة تجربة مدتها 90 يوما، ويحق لكل من الطرفين إنهاء العقد خلال هذه الفترة وفي حال تمت فترة التجربة يتم نقل خدمات الطرف الثاني بعد الاتفاق النهائي.</li>
                    <li>   يستحق الطرف الثاني راتب شهري وقدره  (2,500)ريال  شامل عن 26 يوم عمل في الشهر .</li>
                    <li> التواصل بشكل يومي مع مشرف الطرف الأول في حالة وقوع أي مشكلة لا قدر الله.</li>
                    <li>  في حالة غياب الموظف عن العمل يحتسب غيابه بيوم ونصف ويتم انذاره، وإذا تكرر الغياب بدون عذر ثلاث مرات يتم فصل المندوب ولا يستحق اجر الشهر.</li>
                    <li> الالتزام بالحضور والانصراف في القروب الخاص بكل مستودع وبعدد الشحنات المستلمة والمسلمة والمسترجعة.</li>
                    <li> يجب توصيل الشحنات بنسبة توصيل لا تقل عن %85 ويجب التواصل مع جميع العملاء على الأقل 3 مرات عن طريق قنوات الاتصال المختلفة مثل: الاتصال المباشر او عن طريق الرسال النصية او الواتس اب. </li>
                    <li>  قبول نسبة الطلبات بنسبة لا تقل عن 85 % والا سيتم احتساب الراتب بالطلب حسب ماتراه الشركة مناسب </li>
                    <li> 	العمل لمدة لا تقل عن 10 ساعات يومية متواصلة لعدد 26 يوم والا سيتم احتساب الراتب بالطلب ويتم احتساب الساعات الإضافية ان وجدت. </li>
                </ol>
             </div>

             <div class="col-12" style="text-align: right;">
                <ul style="    background-color: #e0e4f0ba;">
                    <li style="font-size: 18px;">شروط مالية:</li>
                </ul>
             </div>
             <div class="col-12" style="text-align: right;">
                <ol>
                    <li>  الالتزام بتسليم الطلبات بشكل يومي والمحافظة على الطلبات بحيث يتم تسليمها للعميل سليمة.</li>
                    <li> الالتزام بسداد الأموال المستلمة من العملاء (قيمة الطلبات) نهاية كل يوم في الفرع/المستودع.</li>
                    <li>  تتم المحاسبة شهرياً وذلك بعد مراجعة تقرير حضور وانصراف المندوب كأقصى حد يوم 15 من كل شهر. او حسب ما يتم إيداع المبلغ من قبل الشركة الطرف الثالث. </li>
                    <li> الالتزام بتوفير حساب STC PAY باسم الطرف الثاني لتحويل المستحقات على حسابه.</li>
                    <li> الالتزام بإبلاغ المشرف حيال ضياع او فقدان طلب او عدم تسليمها.</li>
                    <li>  في حالة ضياع أي الطلب او تلفها اثنا عملية التوصيل يتحمل المندوب قيمة الشحنة مهما كان المبلغ.</li>
                </ol>
             </div>

             <div class="col-12" style="text-align: right;">
                <ul style="    background-color: #e0e4f0ba;">
                    <li style="font-size: 18px;">شروط ادارية:</li>
                </ul>
             </div>
             <div class="col-12" style="text-align: right;margin-bottom: 24px;">
                <ol>
                    <li> 	يحق للطرف الاول ايقاف الطرف الثاني اذا لم يقوم بتوصيل النسبة المتوقعة منه.</li>
                    <li> لا يتحمل الطرف الأول أي مسائل قانونية مالية حكومية على الطرف الثاني.</li>
                    <li> يتم تقييم الأداء نهاية كل شهر ويحق للشركة فسخ العقد في حال غياب المندوب لأكثر من ثلاثة أيام او اذا كان اداءه ضعيف. </li>
                    <li> إذا كان أداء المندوب ضعيف ونسبة القبول او التوصيل اقل من 75 % يحق للشركة حجز المبلغ حتي يتم التوصل الي حل يرضي الطرفين.</li>
                    <li>يلتزم الطرف الثاني بالموافقة على سند لأمر الكتروني/ورقي في حال تعذر سداد مبالغ مفقودة من الطرف الثاني ويحق للطرف الاول استكمال الاجراءات الادارية القانونية لدى الجهات المختصة.</li>
                    <li> لا يحق للمشرف/المندوب العمل مع شركة منافسة إلا بعد استلام مخالصة موقعة ومختومة من شركة بندر التجارية, وفي حال تم الاخلال بهذه النقطة يحق للشركة خصم 50 % من مستحقات المشرف / المندوب لدينا.</li>
                    <li>تم ابرام هذا العقد من خلال منصة شركة بندر التجارية ويعد هذا العقد موثقاً وملزم للطرفين. </li>
                    <li> للشكاوي والاقتراحات ارسال ايميل علي info@btclogistic.com .</li>
                </ol>
             </div>

             <div class="col-6" style="text-align: center;">
               <span style="font-size: 18px;">توقيع الطرف الاول:</span>
             </div>
             <div class="col-6" style="text-align: center;">
                <span style="font-size: 18px;">توقيع الطرف الثاني:</span>
             </div>
             <br>
             <div class="col-6" style="text-align: center;">
                <!--<img src="sign" alt="" srcset="">-->
                <img style="margin-top: 20px;" src="https://btcdmins.com/btc_stapm.png">
              </div>
              <div class="col-6" style="text-align: center;">
                <img style="width: 46px;margin-top: 20px;" src="{{asset('approve.png')}}" alt="" srcset=""><br>
                <span style="font-size: 18px;background-color: #d9d9d9;"> {{$drivers[0]->driver_signed_date}}</span>
              </div>
        </div>

    </div>



    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>
