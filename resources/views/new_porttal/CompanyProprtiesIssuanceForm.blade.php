<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title> {{$payload[0]->user_name}}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://kit.fontawesome.com/891f45e95b.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>

            #myProgress {
                width: 100%;
                text-align: center;
                /* background-color: #ddd; */
            }

            #myBar {
            width: 1%;
            height: 30px;
            background-color: #04AA6D;
            }
        .footer {
            position: absolute;
            bottom: 44%;
            left: 37%;
            opacity: 0.2;
            z-index: 0;
        }
        .footer2 {
            position: fixed;
            bottom: 44%;
            left: 37%;
            opacity: 0.2;
            z-index: 0;
        }
        #reference{
            font-size: 12px;
        }
        @media only screen and (max-width: 600px) {
             h4{
                font-size: 14px;
             }
             #reference{
                font-size: 10px;
             }
             h5{
                font-size: 12px;
             }
             h6{
                font-size: 12px;
             }
        }
    </style>
    <style>
        body{
            -webkit-print-color-adjust:exact;
            font-family: "Cairo", sans-serif;
            font-optical-sizing: auto;
            font-weight: <weight>;
            font-style: normal;
            font-variation-settings:
                "slnt" 0;
            }
    </style>
</head>
<body  style="width: 100%;direction: rtl;    text-align: right;" >

    <div id="myProgress" style="visibility: hidden">
        <div id="myBar"></div>
        <img style="display: none;width: 34%;margin: 0 auto;" id="loadingGif" src="{{url('c7e1b7b5753737039e1bdbda578132b8.gif')}}" alt="" srcset="">
        <h5 id="feeds" style="text-align: center;">جاري ارسال بيانات الاعتماد ...</h5>
        <button style="display: none;margin: 0 auto;" id="homeBtn" class="btn btn-light" >الرجوع للعهدة</button>
    </div>

    <div id="contentToPrint" >
        <table style="width:100%;" class="uniquifier">
            <tr >
                <th style="width: 20%;"><img style="width: 126px;" src="{{url('/ICONS-07.png')}}" alt="" srcset=""></th>
                <th style="width: 60%;text-align: center;color: #b3a958;"><h4 style="margin: 0;">شركة بندر التجارية</h4> <h4 style="margin: 0;">BANDER TRADING CO</h4></th>
                <th style="width: 20%;text-align: right;"><h4 style="font-size: 16px;"> رقم النموذج:  <span style="font-weight: bold">{{strtoupper($payload[0]->reference_no)}} </span></h4></th>
            </tr>
        </table>
        @if($type != 'view')
            <table style="    width: 75%; margin: 0 auto;" class="uniquifier">
                <tr style="text-align: center;">
                    <th style="width: 100%;background-color: #f2eeee;"><h4 style="margin: 0;">اقرار استلام عهدة</h4> <h4 style="margin: 0;">COMPANY PROPERTY ISSUANCE FORM</h4></th>
                </tr>
            </table>


            <table style="width: 75%; margin: 0 auto;margin-top: 20px;border: 1px solid gray;" class="uniquifier">
                 <tr style="    text-align: center;">
                    <th><h5 style="margin: 0;">اسم الموظف</h5> <h5 style="margin: 0; ">Employee Name</h5></th>
                    <td style="text-align: right;"> <h5>{{$payload[0]->user_name}}</h5></td>
                    <th><h5 style="margin: 0;">   </h5> <h5 style="margin: 0; ">   </h5></th>
                    <td> </td>
                 </tr>
                 <tr style="    text-align: center;">
                    <th><h5 style="margin: 0;">رقم الموظف:</h5> <h5 style="margin: 0; ">Employee number</h5></th>
                    <td><h5 style="text-align: right;">{{$payload[0]->IdentityNo}}</h5></td>
                    <th> </th>
                    <td> </td>
                 </tr>
                 <tr >
                    <th colspan="1" style="    text-align: center;"><h5 style="margin: 0;">القسم/المشروع</h5><h5 style="margin: 0; ">Department/Project</h5></th>
                    <td colspan="3" id="dept_name"><h5>{{$payload[0]->branches}}</h5></td>
                 </tr>
            </table>
        @endif
        <table style="width: 75%; margin: 0 auto;margin-top: 20px;border: 1px solid gray;text-align: center;" class="uniquifier">
            <tr>
                <th style="border: 1px solid black;"><h6 style="margin: 0;">م</h6><h6 style="margin: 0; ">S.No</h6></th>
                <th style="border: 1px solid black;"><h6 style="margin: 0;">وصف البند</h6><h6 style="margin: 0; ">Item details</h6></th>
                <th style="border: 1px solid black;"><h6 style="margin: 0;">الكمية</h6><h6 style="margin: 0; ">Quantity</h6></th>
                <th style="border: 1px solid black;"><h6 style="margin: 0;">تاريخ الاسترجاع</h6><h6 style="margin: 0; ">Date Returnd</h6></th>
            </tr>

                @foreach ($table as $count=>$item)
                    <tr style="direction: ltr;">
                        <td style="border: 1px solid #010101;"> <h6>{{++$count}}</h6></td>
                        <td style="border: 1px solid #010101;"> <h6>{{$item['description']}}</h6> </td>
                        <td style="border: 1px solid #010101;"><h6>{{$item['qty']}}</h6> </td>
                        <td style="border: 1px solid #010101;"> <h6><span style="color:red">NULL</span></h6></td>
                    </tr>
                @endforeach

            <tr>
                <td colspan="4" style="border: 1px solid #010101;">
                <h6 style="text-align: right;padding: 5px;margin: 4px;padding: 5px;">يجب اعتماد المديرالمباشر على جميع البنود عند اعادة هده الممتلكات الى الشركة.</h6>
                <h6 style="text-align: left;padding: 5px;margin: 4px;padding: 5px;">On the final day of employment (0 each item should be signed off as returned by the supervisor and this form signed by him and the employee.</h6>
                </td>
            </tr>

        </table>
        @if($type != 'view')
        <table style="width: 75%; margin: 0 auto;margin-top: 20px;border: 1px solid gray;text-align: center;@if(count($payload)>4) {{'margin-top: 10px;'}}  @endif      " class="uniquifier">
        <tr>
            <th colspan="4" style="DIRECTION: LTR;background-color: #f2eeee;border: 1px solid black;"><h4>UNDERTAKING - تعهــد</h4></th>
        </tr>
        <tr>
            <th colspan="4">
                <h6 style="text-align: right;    margin: 0;">لقد استلمت ممتلكات الشركة المذكورة اعلاه,كما اتعهد على المحافظة على ممتلكات الشركة في حالة جيدة واعادتها للشركة عند انتهاء العمل او في حالة طلب المدير المباشر ذلك.اذا كنت بغير الحاجة لاي من البنود اعلاه, سوف ابلغ مديري بشكل مباشر. سوف اقوم بابلاغ الشركة في حالة تلف او فقدران اي من البنود اعلاه.</h6>
                <h6 style="text-align: left;    margin: 0;">I have received the company property mentioned above. I agree to keep the company property in good condition and return it to the company upon completion of the work or if the direct manager requests it. If you do not need any of the above, I will inform my Manager, I will notify the company if any of the above items are damaged or lost.</h6>
            </th>
        </tr>
        <tr style="background-color: #f1eeee;">
            <th colspan="2" style="border: 1px solid black;"><h4>توقيع الاستلام </h4></th>
            <td colspan="2" style="border: 1px solid black;    padding: 8px;">
            @if($payload[0]->delivery_timestamp == '')
                <button onclick="switAlert('{{$payload[0]->reference_no}}')" class="btn btn-warning" >توقيع استلام العهدة اعلاه <i class="fa-sharp fa-solid fa-exclamation" style="    border: 1px white solid; border-radius: 50%; width: 24px; height: 25px; font-size: 22px; padding: 2px;"></i></button>
            @else
                <img style="width: 40px;    margin: 6px 0px;" src="{{url('checked.png')}}" alt="" srcset=""><br>
                <small>تم تعميد العهدة في : {{$payload[0]->delivery_timestamp}}</small>
            @endif

            </td>

        </tr>
        </table>

        <div class="footer">
            <table style="width: 75%; margin: 0 auto;margin-top:10px;" class="uniquifier">
                <tr >
                    <th colspan="4">


                     <img src="https://btclogistic.com/assets/icons/ICONS-07.png" alt="">
                     {{-- <small>تم تصدير هذا المستند من على نظام شركة بندر التجارية</small> --}}
                    </th>
                    </tr>
            </table>
        </div>


    </div>
    <br>
    {{-- <small>تم اصدار هذة الوثيقة من خلال نظام بندر </small> --}}

    <br>
    {{-- <button id="Convert_HTML_To_PDF"> </button> --}}
    @endif
    <script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>

    <script>
         $( document ).ready(function() {
            console.log("{{$payload[0]->branches}}");
            // document.getElementById("dept_name").innerHTML = "{{$payload[0]->branches}}"

        });

            // Source HTMLElement or a string containing HTML.
            var doc = new jsPDF();
            var specialElementHandlers = {
                '#editor': function (element, renderer) {
                    return true;
                }
            };
            $('#Convert_HTML_To_PDF').click(function () {
                doc.fromHTML($('#contentToPrint').html(), 15, 15, {
                    'width': 170,
                        'elementHandlers': specialElementHandlers
                });
                doc.save('sample-file.pdf');
            });
            function switAlert(args){
                Swal.fire({
                    // title: "هل انت متأكد من تعميد اقرار الأستلام؟",
                    text: "بتعميدك لهذا الاقرار فأنت تأكد استلام جميع بنود العهدة ,هل تريد التأكيد و الاستمرار؟",
                    icon: "question",
                    iconHtml: "؟",
                    confirmButtonText: "تأكيد",
                    cancelButtonText: "الغاء",
                    showCancelButton: true,
                    showCloseButton: true
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        document.getElementById('contentToPrint').style.visibility = "hidden";
                        document.getElementById('myProgress').style.visibility = "visible";
                        document.getElementById('loadingGif').style.display = "block";

                        window.scrollTo(0, 0);
                        var i = 0;
                        if (i == 0) {
                            i = 1;
                            var elem = document.getElementById("myBar");
                            var width = 1;
                            var id = setInterval(frame, 10);
                            function frame() {
                                if (width == 100) {
                                    clearInterval(id);
                                    i = 0;
                                    document.getElementById("feeds").innerHTML = " جاري الاتصال بمزود الخدمة لتأكيد العهدة :#"+ '{{$payload[0]->reference_no}}' +"";
                                    var client = new HttpClient();
                                    client.get("{{url('Properties/emp/confirm/')}}"+'/'+args, function(response) {
                                        // do something with response
                                        // document.getElementById('loadingGif').style.display = "none";
                                        document.getElementById('loadingGif').src= "{{url('4a10e39ee8325a06daf00881ac321b2f.gif')}}";

                                        // 4a10e39ee8325a06daf00881ac321b2f.gif
                                        document.getElementById("feeds").innerHTML = " تم تأكيد استلام العهدة :#"+ '{{$payload[0]->reference_no}}' +"";
                                        document.getElementById('homeBtn').style.display = "block";
                                    });
                                    console.log('ss');
                                } else {
                                    width++;
                                    elem.style.width = width + "%";
                                }
                            }
                        }
                        // Swal.fire("Saved!", "", "success");
                    } else if (result.isDenied) {
                        Swal.fire("تم الغاء العملية ", "", "info");
                    }
                });
            }
            var HttpClient = function() {
                this.get = function(aUrl, aCallback) {
                    var anHttpRequest = new XMLHttpRequest();
                    anHttpRequest.onreadystatechange = function() {
                        if (anHttpRequest.readyState == 4 && anHttpRequest.status == 200)
                            aCallback(anHttpRequest.responseText);
                    }
                    anHttpRequest.open( "GET", aUrl, true );
                    anHttpRequest.send( null );
                }
            }
            $('#homeBtn').click(function(){

                document.location.href="{{url('/Properties/Form/'.$payload[0]->reference_no)}}";
            })
    </script>
</body>
</html>
