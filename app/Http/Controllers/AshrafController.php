<?php

namespace App\Http\Controllers;
use DB;
use PDF;
use Auth;
use TCPDF;
use App\Loan;
use App\Drivers;
use App\Journal;
use App\packages_report;
use App\CreditNotes;
use App\Settlements;
use setasign\Fpdi\Tcpdf\Fpdi; 
use Illuminate\Http\Request;

class AshrafController extends Controller
{
  function landmarkHandlller() {
      $report_data = '[
        {
            "name": "BADUR NOORMOHAMMAD AZHARMIAH",
            "idNumber": 2205979566,
            "plateInfo": "بصب_2477_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-05-01",
            "createdDate": "2024-05-01T13:24:14.907Z",
            "mobileNumber": "581121548",
            "lastActionType": 1,
            "endDate": "2025-04-16T16:23:10.633",
            "sequenceNumber": 588318810,
            "startDate": "2024-05-01T16:23:10.633",
            "authorizationType": 1,
            "authorizationDays": 350,
            "authorizationNumber": 101445007209883,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "3670b31238979d95",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "63d1e4c7b9c2d4e6",
            "isPostpaid": true
        },
        {
            "name": "ابراهيم محمود حمزه عباس",
            "idNumber": 2505553103,
            "plateInfo": "رقب_1951_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-05-01",
            "createdDate": "2024-05-01T12:44:22.383Z",
            "mobileNumber": "531138893",
            "lastActionType": 1,
            "endDate": "2025-04-16T15:43:18.653",
            "sequenceNumber": 203055020,
            "startDate": "2024-05-01T15:43:18.653",
            "authorizationType": 1,
            "authorizationDays": 350,
            "authorizationNumber": 101445007208556,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "eae4407aeb64131c",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "3a788ed85e1a546f",
            "isPostpaid": true
        },
        {
            "name": "ايهاب على محمد الطيب",
            "idNumber": 2564794044,
            "plateInfo": "رحم_6487_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-05-01",
            "createdDate": "2024-05-01T12:28:57.703Z",
            "mobileNumber": "500781966",
            "lastActionType": 1,
            "endDate": "2025-04-16T15:27:48.25",
            "sequenceNumber": 659352910,
            "startDate": "2024-05-01T15:27:48.25",
            "authorizationType": 1,
            "authorizationDays": 350,
            "authorizationNumber": 101445007208064,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "8d2314965bf301a5",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "d1a797bb294c302f",
            "isPostpaid": true
        },
        {
            "name": "ابراهيم قريب العطا - ابو الحية",
            "idNumber": 2141096608,
            "plateInfo": "رحم_6493_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-05-01",
            "createdDate": "2024-05-01T12:04:33.217Z",
            "mobileNumber": "506204572",
            "lastActionType": 1,
            "endDate": "2025-04-16T15:02:34.763",
            "sequenceNumber": 151452910,
            "startDate": "2024-05-01T15:02:34.763",
            "authorizationType": 1,
            "authorizationDays": 350,
            "authorizationNumber": 101445007207209,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "d21cfa7c76c561b8",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "96cc85316a5fd677",
            "isPostpaid": true
        },
        {
            "name": "يوسف عبدالرحمن يونس صغير",
            "idNumber": 2015146398,
            "plateInfo": "بعأ_1913_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-05-01",
            "createdDate": "2024-05-01T12:00:27.987Z",
            "mobileNumber": "538586543",
            "lastActionType": 1,
            "endDate": "2025-04-16T14:52:57.013",
            "sequenceNumber": 284746020,
            "startDate": "2024-05-01T14:52:57.013",
            "authorizationType": 1,
            "authorizationDays": 350,
            "authorizationNumber": 101445007207079,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "8fbcb589c87aaaef",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "4bb91a19e8624e5b",
            "isPostpaid": true
        },
        {
            "name": "الياس حسين بانقا يعقوب",
            "idNumber": 2507301493,
            "plateInfo": "بصب_2483_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-05-01",
            "createdDate": "2024-05-01T11:38:58.967Z",
            "mobileNumber": "582546828",
            "lastActionType": 1,
            "endDate": "2025-04-16T14:37:58.52",
            "sequenceNumber": 239318810,
            "startDate": "2024-05-01T14:37:58.52",
            "authorizationType": 1,
            "authorizationDays": 350,
            "authorizationNumber": 101445007206367,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "957f924b5669e5f6",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "150851cb716b1585",
            "isPostpaid": true
        },
        {
            "name": "بشير صلاح ابراهيم محمد",
            "idNumber": 2463838181,
            "plateInfo": "بطط_8472_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-05-01",
            "createdDate": "2024-05-01T09:04:48.240Z",
            "mobileNumber": "565621470",
            "lastActionType": 1,
            "endDate": "2025-04-16T12:03:27.923",
            "sequenceNumber": 325621020,
            "startDate": "2024-05-01T12:03:27.923",
            "authorizationType": 1,
            "authorizationDays": 350,
            "authorizationNumber": 101445007201013,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "dcdcf39eae75b31e",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "2492d17f5e04e7b7",
            "isPostpaid": true
        },
        {
            "name": "عبدالله المتولي محمد ابوزيد",
            "idNumber": 2493311423,
            "plateInfo": "رقب_1953_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-30",
            "createdDate": "2024-04-30T17:12:24.093Z",
            "mobileNumber": "554861983",
            "lastActionType": 1,
            "endDate": "2024-06-30T20:11:49.27",
            "sequenceNumber": 413055020,
            "startDate": "2024-04-30T20:11:49.27",
            "authorizationType": 1,
            "authorizationDays": 61,
            "authorizationNumber": 101445007183963,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "3b14b09ee4c7922c",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "e42b01e8290f0ed5",
            "isPostpaid": true
        },
        {
            "name": "YOUSSOUF BECHIR MOUSSA ADAM",
            "idNumber": 2151651052,
            "plateInfo": "رحط_8305_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-30",
            "createdDate": "2024-04-30T13:38:23.207Z",
            "mobileNumber": "566056721",
            "lastActionType": 1,
            "endDate": "2024-05-10T16:37:36.853",
            "sequenceNumber": 765512910,
            "startDate": "2024-04-30T16:37:36.853",
            "authorizationType": 1,
            "authorizationDays": 10,
            "authorizationNumber": 101445007176266,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2068943584,
            "traceId": "c309f20ae2031db7",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "f9991633d16f611a",
            "isPostpaid": true
        },
        {
            "name": "ابراهيم ابوالغيث ابراهيم طه",
            "idNumber": 2478603869,
            "plateInfo": "بصب_2471_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-30",
            "createdDate": "2024-04-30T13:12:01.903Z",
            "mobileNumber": "544437478",
            "lastActionType": 1,
            "endDate": "2025-04-15T16:10:37.343",
            "sequenceNumber": 19318810,
            "startDate": "2024-04-30T16:10:37.343",
            "authorizationType": 1,
            "authorizationDays": 350,
            "authorizationNumber": 101445007175220,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "72fb6f3fa533d8da",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "1bc8fcd36a6d6288",
            "isPostpaid": true
        },
        {
            "name": "MALIK USMAN AHMED - HAQ DAD",
            "idNumber": 2151215189,
            "plateInfo": "بصب_8239_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-30",
            "createdDate": "2024-04-30T11:27:26.417Z",
            "mobileNumber": "501115574",
            "lastActionType": 1,
            "endDate": "2024-06-30T14:24:36.863",
            "sequenceNumber": 865700910,
            "startDate": "2024-04-30T14:24:36.863",
            "authorizationType": 1,
            "authorizationDays": 61,
            "authorizationNumber": 101445007171865,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "363413abcc640cd6",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "e6043b4e43fc229c",
            "isPostpaid": true
        },
        {
            "name": "احمد نصر الحسين",
            "idNumber": 2315058343,
            "plateInfo": "بصب_8249_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-30",
            "createdDate": "2024-04-30T11:20:40.957Z",
            "mobileNumber": "550389723",
            "lastActionType": 1,
            "endDate": "2025-04-15T14:16:39.393",
            "sequenceNumber": 796700910,
            "startDate": "2024-04-30T14:16:39.393",
            "authorizationType": 1,
            "authorizationDays": 350,
            "authorizationNumber": 101445007171662,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "04a22eb3a7fe5da4",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "8a4befd971fad187",
            "isPostpaid": true
        },
        {
            "name": "غمدان ماجد محسن محسن العصري",
            "idNumber": 2500364621,
            "plateInfo": "بصب_8229_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-30",
            "createdDate": "2024-04-30T09:11:41.887Z",
            "mobileNumber": "566210074",
            "lastActionType": 1,
            "endDate": "2025-04-15T12:05:57.03",
            "sequenceNumber": 204700910,
            "startDate": "2024-04-30T12:05:57.03",
            "authorizationType": 1,
            "authorizationDays": 350,
            "authorizationNumber": 101445007167489,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "6ca669264886895a",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "66b6ac163e5837d1",
            "isPostpaid": true
        },
        {
            "name": "احمد يوسف عبدالله عمر",
            "idNumber": 2502943828,
            "plateInfo": "رحم_6430_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-29",
            "createdDate": "2024-04-29T12:09:51.883Z",
            "mobileNumber": "507218994",
            "lastActionType": 1,
            "endDate": "2025-04-14T15:08:37.33",
            "sequenceNumber": 159452910,
            "startDate": "2024-04-29T15:08:37.33",
            "authorizationType": 1,
            "authorizationDays": 350,
            "authorizationNumber": 101445007141323,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "c673ebc168745118",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "a2109338e190fb05",
            "isPostpaid": true
        },
        {
            "name": "محمداحمد صلاح الطاهر حامد",
            "idNumber": 2509665713,
            "plateInfo": "بعأ_1022_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-27",
            "createdDate": "2024-04-27T08:15:56.157Z",
            "mobileNumber": "507156441",
            "lastActionType": 1,
            "endDate": "2024-07-31T11:15:22.547",
            "sequenceNumber": 552746020,
            "startDate": "2024-04-27T11:15:22.547",
            "authorizationType": 1,
            "authorizationDays": 95,
            "authorizationNumber": 101445007070933,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "7f85948117219816",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "0e41f06260a5454c",
            "isPostpaid": true
        },
        {
            "name": "WAJID KHAN AKBAR HUSSAIN",
            "idNumber": 2464318654,
            "plateInfo": "بصب_8262_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-25",
            "createdDate": "2024-04-25T08:32:14.027Z",
            "mobileNumber": "501271392",
            "lastActionType": 1,
            "endDate": "2025-04-10T11:27:54.91",
            "sequenceNumber": 279700910,
            "startDate": "2024-04-25T11:27:54.91",
            "authorizationType": 1,
            "authorizationDays": 350,
            "authorizationNumber": 101445007027114,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "853372fa7f021f17",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "086af9870372f9e7",
            "isPostpaid": true
        },
        {
            "name": "عامر حسن رمضان احمد",
            "idNumber": 2536340512,
            "plateInfo": "رحن_4591_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-24",
            "createdDate": "2024-04-24T14:56:05.850Z",
            "mobileNumber": "533680165",
            "lastActionType": 1,
            "endDate": "2025-04-09T17:55:33.153",
            "sequenceNumber": 391862910,
            "startDate": "2024-04-24T17:55:33.153",
            "authorizationType": 1,
            "authorizationDays": 350,
            "authorizationNumber": 101445007009122,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "71eccc7f4dedb507",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "49a6581a96884bca",
            "isPostpaid": true
        },
        {
            "name": "مهدي الجزولي محجوب احمد",
            "idNumber": 2481334940,
            "plateInfo": "رحن_4551_1",
            "canCancel": false,
            "canExtend": true,
            "issueDate": "2024-04-24",
            "createdDate": "2024-04-24T14:15:16.010Z",
            "mobileNumber": "556805236",
            "lastActionType": 3,
            "endDate": "2024-05-01T16:44:54.257",
            "sequenceNumber": 291862910,
            "startDate": "2024-04-24T17:14:47.533",
            "authorizationType": 1,
            "authorizationDays": 350,
            "authorizationNumber": 101445007007613,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "62b21f7faea38713",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "0d74589d6fdf9b2b",
            "isPostpaid": true
        },
        {
            "name": "ABDALLAH NAJMALDIN NOOR AHMED BASA MIAH",
            "idNumber": 2547755450,
            "plateInfo": "بصب_2481_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-24",
            "createdDate": "2024-04-24T12:19:58.993Z",
            "mobileNumber": "578241607",
            "lastActionType": 1,
            "endDate": "2025-04-09T14:59:53.11",
            "sequenceNumber": 709318810,
            "startDate": "2024-04-24T14:59:53.11",
            "authorizationType": 1,
            "authorizationDays": 350,
            "authorizationNumber": 101445007004249,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "1fc5a9f82bc0a215",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "7fd5fc495f650587",
            "isPostpaid": true
        },
        {
            "name": "النعيم بشير احمد ابراهيم",
            "idNumber": 2465485833,
            "plateInfo": "بطط_8468_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-24",
            "createdDate": "2024-04-24T09:44:56.023Z",
            "mobileNumber": "534510898",
            "lastActionType": 1,
            "endDate": "2025-04-09T12:44:07.75",
            "sequenceNumber": 794621020,
            "startDate": "2024-04-24T12:44:07.75",
            "authorizationType": 1,
            "authorizationDays": 350,
            "authorizationNumber": 101445007000510,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "bc933896f0772c12",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "a576cf94e7b722a6",
            "isPostpaid": true
        },
        {
            "name": "احمد عبدالوهاب على احمد",
            "idNumber": 2487629624,
            "plateInfo": "بطط_8470_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-24",
            "createdDate": "2024-04-24T08:30:21.453Z",
            "mobileNumber": "542310403",
            "lastActionType": 1,
            "endDate": "2025-04-09T11:28:50.077",
            "sequenceNumber": 505621020,
            "startDate": "2024-04-24T11:28:50.077",
            "authorizationType": 1,
            "authorizationDays": 350,
            "authorizationNumber": 101445006998408,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "e88e17cffe7fc718",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "6fd6024d04eeba51",
            "isPostpaid": true
        },
        {
            "name": "سعيد محمود بلال ادريس",
            "idNumber": 2474706583,
            "plateInfo": "رحم_6534_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-23",
            "createdDate": "2024-04-23T14:03:22.100Z",
            "mobileNumber": "554368622",
            "lastActionType": 1,
            "endDate": "2025-04-08T16:59:03.503",
            "sequenceNumber": 141512910,
            "startDate": "2024-04-23T16:59:03.503",
            "authorizationType": 1,
            "authorizationDays": 350,
            "authorizationNumber": 101445006979472,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "7b9ff9fd5cb64045",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "0fa6574a2836c091",
            "isPostpaid": true
        },
        {
            "name": "فريد عمر حامد عمر",
            "idNumber": 2496890035,
            "plateInfo": "بسن_4975_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-23",
            "createdDate": "2024-04-23T10:26:37.930Z",
            "mobileNumber": "578624409",
            "lastActionType": 1,
            "endDate": "2025-04-08T13:25:12.917",
            "sequenceNumber": 963738810,
            "startDate": "2024-04-23T13:25:12.917",
            "authorizationType": 1,
            "authorizationDays": 350,
            "authorizationNumber": 101445006973426,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "0704cb6dea738ff6",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "1ed3b2333a1f4671",
            "isPostpaid": true
        },
        {
            "name": "احمد عبدالباقي احمد ابراهيم",
            "idNumber": 2451813279,
            "plateInfo": "رحط_8309_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-22",
            "createdDate": "2024-04-22T12:39:34Z",
            "mobileNumber": "555319608",
            "lastActionType": 1,
            "endDate": "2025-04-07T15:38:32.387",
            "sequenceNumber": 795512910,
            "startDate": "2024-04-22T15:38:32.387",
            "authorizationType": 1,
            "authorizationDays": 350,
            "authorizationNumber": 101445006948089,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "090db4b61ce76c48",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "710667094f583041",
            "isPostpaid": true
        },
        {
            "name": "خالد ابراهيم سالم سالم",
            "idNumber": 2498451737,
            "plateInfo": "رحن_4356_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-22",
            "createdDate": "2024-04-22T12:25:56.883Z",
            "mobileNumber": "509688545",
            "lastActionType": 1,
            "endDate": "2025-04-07T15:24:51.877",
            "sequenceNumber": 553552910,
            "startDate": "2024-04-22T15:24:51.877",
            "authorizationType": 1,
            "authorizationDays": 350,
            "authorizationNumber": 101445006947751,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "f41d53883a45f698",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "526c976a6d44d3aa",
            "isPostpaid": true
        },
        {
            "name": "يحيى محمد محمد احمد الدواء",
            "idNumber": 2470742137,
            "plateInfo": "رحم_6515_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-22",
            "createdDate": "2024-04-22T12:06:05.717Z",
            "mobileNumber": "552659130",
            "lastActionType": 1,
            "endDate": "2025-04-07T15:02:18.103",
            "sequenceNumber": 680512910,
            "startDate": "2024-04-22T15:02:18.103",
            "authorizationType": 1,
            "authorizationDays": 350,
            "authorizationNumber": 101445006947139,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "120894ff08e01714",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "e511d3bb07585801",
            "isPostpaid": true
        },
        {
            "name": "ناجي صلاح محمد على",
            "idNumber": 2494589969,
            "plateInfo": "بصب_8225_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-22",
            "createdDate": "2024-04-22T11:16:31.183Z",
            "mobileNumber": "563658737",
            "lastActionType": 1,
            "endDate": "2025-04-06T14:15:49.113",
            "sequenceNumber": 353700910,
            "startDate": "2024-04-22T14:15:49.113",
            "authorizationType": 1,
            "authorizationDays": 349,
            "authorizationNumber": 101445006945818,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "d76eaa42d403d022",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "b64460de36f0d42e",
            "isPostpaid": true
        },
        {
            "name": "جعفر اسماعيل عبدالجليل محمد خير",
            "idNumber": 2464463211,
            "plateInfo": "بصب_8245_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-22",
            "createdDate": "2024-04-22T09:52:46.587Z",
            "mobileNumber": "508225902",
            "lastActionType": 1,
            "endDate": "2025-04-06T12:51:05.287",
            "sequenceNumber": 236700910,
            "startDate": "2024-04-22T12:51:05.287",
            "authorizationType": 1,
            "authorizationDays": 349,
            "authorizationNumber": 101445006943721,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "8e825f8467d9faac",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "9a6f745d81cf27dc",
            "isPostpaid": true
        },
        {
            "name": "المنذر محمد محمود قسم السيد",
            "idNumber": 2515549943,
            "plateInfo": "رحم_6431_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-21",
            "createdDate": "2024-04-21T13:37:12.183Z",
            "mobileNumber": "508562343",
            "lastActionType": 1,
            "endDate": "2025-04-05T16:36:19.007",
            "sequenceNumber": 269452910,
            "startDate": "2024-04-21T16:36:19.007",
            "authorizationType": 1,
            "authorizationDays": 349,
            "authorizationNumber": 101445006921109,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "84d3e1482800a107",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "02865925af108369",
            "isPostpaid": true
        },
        {
            "name": "عاصم عبدالله بجاش ثابت",
            "idNumber": 2054364472,
            "plateInfo": "رحم_6460_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-21",
            "createdDate": "2024-04-21T13:27:11.867Z",
            "mobileNumber": "508062349",
            "lastActionType": 1,
            "endDate": "2025-02-28T16:26:23.007",
            "sequenceNumber": 639452910,
            "startDate": "2024-04-21T16:26:23.007",
            "authorizationType": 1,
            "authorizationDays": 313,
            "authorizationNumber": 101445006920775,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "70f46bdd82040750",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "01545eae276f8cc2",
            "isPostpaid": true
        },
        {
            "name": "سعد فتحي عبد الفتاح عبده",
            "idNumber": 2226482145,
            "plateInfo": "رصن_5437_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-21",
            "createdDate": "2024-04-21T12:25:52.917Z",
            "mobileNumber": "570743513",
            "lastActionType": 1,
            "endDate": "2025-04-05T15:24:33.993",
            "sequenceNumber": 11410020,
            "startDate": "2024-04-21T15:24:33.993",
            "authorizationType": 1,
            "authorizationDays": 349,
            "authorizationNumber": 101445006919058,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "fb8b6b285a4382a1",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "b6cb380f6ade856f",
            "isPostpaid": true
        },
        {
            "name": "الكباشي حمد النيل عوض الجيد الشيخ",
            "idNumber": 2514053947,
            "plateInfo": "بعأ_1906_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-21",
            "createdDate": "2024-04-21T12:22:33.553Z",
            "mobileNumber": "536933765",
            "lastActionType": 1,
            "endDate": "2025-04-05T15:17:07.243",
            "sequenceNumber": 193746020,
            "startDate": "2024-04-21T15:17:07.243",
            "authorizationType": 1,
            "authorizationDays": 349,
            "authorizationNumber": 101445006918971,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "25e99b0c709d9843",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "0b5014c551fd91f4",
            "isPostpaid": true
        },
        {
            "name": "مازن هاشم ابراهيم قرشي",
            "idNumber": 2534623257,
            "plateInfo": "رصن_5154_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-21",
            "createdDate": "2024-04-21T12:12:58.957Z",
            "mobileNumber": "569232445",
            "lastActionType": 1,
            "endDate": "2025-04-05T15:11:38.727",
            "sequenceNumber": 870410020,
            "startDate": "2024-04-21T15:11:38.727",
            "authorizationType": 1,
            "authorizationDays": 349,
            "authorizationNumber": 101445006918713,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "dd6bac403d42ccb3",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "f4b7a91e16e08816",
            "isPostpaid": true
        },
        {
            "name": "امير ادريس فضل المولي محمد",
            "idNumber": 2317593479,
            "plateInfo": "بسن_4975_3",
            "canCancel": false,
            "canExtend": false,
            "issueDate": "2024-04-21",
            "createdDate": "2024-04-21T12:03:56.920Z",
            "mobileNumber": "533842502",
            "lastActionType": 3,
            "endDate": "2024-04-23T12:29:56.97",
            "sequenceNumber": 963738810,
            "startDate": "2024-04-21T15:02:17.387",
            "authorizationType": 1,
            "authorizationDays": 349,
            "authorizationNumber": 101445006918409,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "fa49961eb9e97bc2",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "5c88707e267a6a44",
            "isPostpaid": true
        },
        {
            "name": "SAKANDAR MUNIR MUNIR AHMAD",
            "idNumber": 2515854269,
            "plateInfo": "رصن_5431_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-21",
            "createdDate": "2024-04-21T11:54:12.373Z",
            "mobileNumber": "567782528",
            "lastActionType": 1,
            "endDate": "2025-04-05T14:53:02.33",
            "sequenceNumber": 853410020,
            "startDate": "2024-04-21T14:53:02.33",
            "authorizationType": 1,
            "authorizationDays": 349,
            "authorizationNumber": 101445006918101,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "c90dd1139e3001b7",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "a60ae0719d2b3e12",
            "isPostpaid": true
        },
        {
            "name": "محمدالخاتم قريب الله محمد علي مصطفي",
            "idNumber": 2504636644,
            "plateInfo": "رصن_5440_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-21",
            "createdDate": "2024-04-21T11:46:54.840Z",
            "mobileNumber": "549133132",
            "lastActionType": 1,
            "endDate": "2025-04-05T14:45:29.233",
            "sequenceNumber": 621410020,
            "startDate": "2024-04-21T14:45:29.233",
            "authorizationType": 1,
            "authorizationDays": 349,
            "authorizationNumber": 101445006917907,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "1c41d6518e56b529",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "88f91f403b584329",
            "isPostpaid": true
        },
        {
            "name": "MAHMOOD MOHAMMAD FLATON",
            "idNumber": 2211714718,
            "plateInfo": "بصب_8253_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-21",
            "createdDate": "2024-04-21T11:39:23.053Z",
            "mobileNumber": "578180573",
            "lastActionType": 1,
            "endDate": "2025-04-05T14:38:09.353",
            "sequenceNumber": 558700910,
            "startDate": "2024-04-21T14:38:09.353",
            "authorizationType": 1,
            "authorizationDays": 349,
            "authorizationNumber": 101445006917712,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "7bec5a27b4dade01",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "9893c1aacefd3ee6",
            "isPostpaid": true
        },
        {
            "name": "SAMIR ABDULGANI ABDULSHAKOR",
            "idNumber": 2548262803,
            "plateInfo": "بسن_4978_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-21",
            "createdDate": "2024-04-21T11:31:05.010Z",
            "mobileNumber": "577191975",
            "lastActionType": 1,
            "endDate": "2025-04-05T14:19:56.803",
            "sequenceNumber": 704738810,
            "startDate": "2024-04-21T14:19:56.803",
            "authorizationType": 1,
            "authorizationDays": 349,
            "authorizationNumber": 101445006917474,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "53d8242b2cdc340d",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "22e8edcbf9fc7b85",
            "isPostpaid": true
        },
        {
            "name": "راكان محمد حسين دغمش",
            "idNumber": 2132583366,
            "plateInfo": "بعأ_1908_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-21",
            "createdDate": "2024-04-21T09:40:53.547Z",
            "mobileNumber": "544973204",
            "lastActionType": 1,
            "endDate": "2024-09-30T12:39:45.813",
            "sequenceNumber": 524746020,
            "startDate": "2024-04-21T12:39:45.813",
            "authorizationType": 1,
            "authorizationDays": 162,
            "authorizationNumber": 101445006914681,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "138a6dedd191555e",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "54ad86868f035592",
            "isPostpaid": true
        },
        {
            "name": "قابوس سعيد محمد عبدالله الميرابي",
            "idNumber": 2501562678,
            "plateInfo": "بصب_8229_3",
            "canCancel": false,
            "canExtend": false,
            "issueDate": "2024-04-21",
            "createdDate": "2024-04-21T08:52:16.677Z",
            "mobileNumber": "562579284",
            "lastActionType": 3,
            "endDate": "2024-04-30T12:05:22.333",
            "sequenceNumber": 204700910,
            "startDate": "2024-04-21T11:50:53.357",
            "authorizationType": 1,
            "authorizationDays": 349,
            "authorizationNumber": 101445006913294,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "6db6f90529978cfe",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "0c2ae0ab6030cbb7",
            "isPostpaid": true
        },
        {
            "name": "MEHMOOD ALI KHAMISO",
            "idNumber": 2316941711,
            "plateInfo": "بصب_8232_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-21",
            "createdDate": "2024-04-21T08:09:39.267Z",
            "mobileNumber": "593740297",
            "lastActionType": 1,
            "endDate": "2025-04-05T11:08:21.377",
            "sequenceNumber": 734700910,
            "startDate": "2024-04-21T11:08:21.377",
            "authorizationType": 1,
            "authorizationDays": 349,
            "authorizationNumber": 101445006911662,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "d84788f781fa4948",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "c61de254fd937bfe",
            "isPostpaid": true
        },
        {
            "name": "غمدان ماجد محسن محسن العصري",
            "idNumber": 2500364621,
            "plateInfo": "بصب_8267_3",
            "canCancel": false,
            "canExtend": false,
            "issueDate": "2024-04-21",
            "createdDate": "2024-04-21T07:40:24.650Z",
            "mobileNumber": "566210074",
            "lastActionType": 3,
            "endDate": "2024-04-30T12:13:45.837",
            "sequenceNumber": 210800910,
            "startDate": "2024-04-21T10:39:13.873",
            "authorizationType": 1,
            "authorizationDays": 349,
            "authorizationNumber": 101445006910664,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "0ef1934a8c33e1af",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "e6acc0b7c29ddfa0",
            "isPostpaid": true
        },
        {
            "name": "محمد عمر مضوى فضل الله",
            "idNumber": 2493915280,
            "plateInfo": "رصن_5433_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-18",
            "createdDate": "2024-04-18T14:42:26.603Z",
            "mobileNumber": "509131070",
            "lastActionType": 1,
            "endDate": "2025-03-31T17:40:31.27",
            "sequenceNumber": 333410020,
            "startDate": "2024-04-18T17:40:31.27",
            "authorizationType": 1,
            "authorizationDays": 347,
            "authorizationNumber": 101445006854959,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "2d34c5b145b1e9ee",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "732329a63fa96897",
            "isPostpaid": true
        },
        {
            "name": "RAHMATULLAH MUHAMMAD UMAR",
            "idNumber": 2522725643,
            "plateInfo": "بعأ_1909_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-18",
            "createdDate": "2024-04-18T14:18:12.607Z",
            "mobileNumber": "551059313",
            "lastActionType": 1,
            "endDate": "2025-03-31T17:16:35.493",
            "sequenceNumber": 634746020,
            "startDate": "2024-04-18T17:16:35.493",
            "authorizationType": 1,
            "authorizationDays": 347,
            "authorizationNumber": 101445006854089,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "8058c26c9d1c3370",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "8a1a4c26e01e3324",
            "isPostpaid": true
        },
        {
            "name": "عماد الدين عبدالرحيم احمد رمضان",
            "idNumber": 2479295301,
            "plateInfo": "رحن_4591_1",
            "canCancel": false,
            "canExtend": false,
            "issueDate": "2024-04-18",
            "createdDate": "2024-04-18T13:53:50.687Z",
            "mobileNumber": "502979364",
            "lastActionType": 3,
            "endDate": "2024-04-24T17:51:28.19",
            "sequenceNumber": 391862910,
            "startDate": "2024-04-18T16:52:45.103",
            "authorizationType": 1,
            "authorizationDays": 205,
            "authorizationNumber": 101445006853223,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "4825511aedc9ef78",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "0845392d7e8669d8",
            "isPostpaid": true
        },
        {
            "name": "ABDULAZEZ MOHAMMED YOUNUS ABDULHAMID",
            "idNumber": 2367063274,
            "plateInfo": "بصب_8235_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-18",
            "createdDate": "2024-04-18T13:44:10.797Z",
            "mobileNumber": "509907021",
            "lastActionType": 1,
            "endDate": "2025-03-31T16:42:44.773",
            "sequenceNumber": 74700910,
            "startDate": "2024-04-18T16:42:44.773",
            "authorizationType": 1,
            "authorizationDays": 347,
            "authorizationNumber": 101445006852872,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "81ced46cc7616c73",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "c15ecf74c7846849",
            "isPostpaid": true
        },
        {
            "name": "MANZAR ALI GHULAM QADIR",
            "idNumber": 2552497279,
            "plateInfo": "بصب_8266_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-18",
            "createdDate": "2024-04-18T13:25:46.560Z",
            "mobileNumber": "598532686",
            "lastActionType": 1,
            "endDate": "2024-12-31T16:24:12.753",
            "sequenceNumber": 400800910,
            "startDate": "2024-04-18T16:24:12.753",
            "authorizationType": 1,
            "authorizationDays": 257,
            "authorizationNumber": 101445006852222,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2456028931,
            "traceId": "76ac12b036446d11",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "02d4b0442ee9028a",
            "isPostpaid": true
        },
        {
            "name": "KHUBAB MEHMOOD JAMIL MEHMOOD",
            "idNumber": 2511085454,
            "plateInfo": "رصن_5438_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-18",
            "createdDate": "2024-04-18T12:16:36.947Z",
            "mobileNumber": "509971078",
            "lastActionType": 1,
            "endDate": "2025-03-31T15:15:25.133",
            "sequenceNumber": 21410020,
            "startDate": "2024-04-18T15:15:25.133",
            "authorizationType": 1,
            "authorizationDays": 347,
            "authorizationNumber": 101445006850204,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "62b344e059e41735",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "f2ec472c6a434328",
            "isPostpaid": true
        },
        {
            "name": "ابوبكر حسين الحاج حسين",
            "idNumber": 2429461169,
            "plateInfo": "رصن_5446_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-18",
            "createdDate": "2024-04-18T12:13:21.013Z",
            "mobileNumber": "538734775",
            "lastActionType": 1,
            "endDate": "2025-03-31T15:12:48.973",
            "sequenceNumber": 882410020,
            "startDate": "2024-04-18T15:12:48.973",
            "authorizationType": 1,
            "authorizationDays": 347,
            "authorizationNumber": 101445006850106,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "fb98eba7d34a4ecd",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "fc460f9a621b8d45",
            "isPostpaid": true
        },
        {
            "name": "MUHAMMAD RAHIM KHOG JAN",
            "idNumber": 2493688721,
            "plateInfo": "رصن_5158_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-18",
            "createdDate": "2024-04-18T12:05:22.110Z",
            "mobileNumber": "592341765",
            "lastActionType": 1,
            "endDate": "2025-03-31T14:58:41.733",
            "sequenceNumber": 471410020,
            "startDate": "2024-04-18T14:58:41.733",
            "authorizationType": 1,
            "authorizationDays": 347,
            "authorizationNumber": 101445006849877,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "c14fb2621d644075",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "3a8e3034e83bf8e8",
            "isPostpaid": true
        },
        {
            "name": "الفاتح ابراهيم قسم السيد المبارك",
            "idNumber": 2458162969,
            "plateInfo": "بصب_8246_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-18",
            "createdDate": "2024-04-18T11:34:34.423Z",
            "mobileNumber": "550469236",
            "lastActionType": 1,
            "endDate": "2025-03-31T14:32:44.263",
            "sequenceNumber": 246700910,
            "startDate": "2024-04-18T14:32:44.263",
            "authorizationType": 1,
            "authorizationDays": 347,
            "authorizationNumber": 101445006849049,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "176f692b6338d281",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "ec36d707d8162c54",
            "isPostpaid": true
        },
        {
            "name": "IBRAHIM RASHID",
            "idNumber": 2136281678,
            "plateInfo": "بعأ_1911_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-18",
            "createdDate": "2024-04-18T11:28:39.450Z",
            "mobileNumber": "593314629",
            "lastActionType": 1,
            "endDate": "2025-03-31T14:25:07.78",
            "sequenceNumber": 364746020,
            "startDate": "2024-04-18T14:25:07.78",
            "authorizationType": 1,
            "authorizationDays": 347,
            "authorizationNumber": 101445006848904,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "fff947ad3fd677b7",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "c1d7db4243d0b8e9",
            "isPostpaid": true
        },
        {
            "name": "محمد عبدالله احمد عوض السيد",
            "idNumber": 2495307387,
            "plateInfo": "بعأ_1026_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-17",
            "createdDate": "2024-04-17T08:18:08.683Z",
            "mobileNumber": "553500318",
            "lastActionType": 1,
            "endDate": "2025-03-31T11:17:53.4",
            "sequenceNumber": 692746020,
            "startDate": "2024-04-17T11:17:53.4",
            "authorizationType": 1,
            "authorizationDays": 348,
            "authorizationNumber": 101445006818553,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "1b8c61c67459216e",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "9163930408a2c6f2",
            "isPostpaid": true
        },
        {
            "name": "ALI KHAN AMJID ALI",
            "idNumber": 2482381171,
            "plateInfo": "بطط_8471_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-16",
            "createdDate": "2024-04-16T13:46:44.177Z",
            "mobileNumber": "501694784",
            "lastActionType": 1,
            "endDate": "2025-03-31T16:45:52.4",
            "sequenceNumber": 715621020,
            "startDate": "2024-04-16T16:45:52.4",
            "authorizationType": 1,
            "authorizationDays": 349,
            "authorizationNumber": 101445006801098,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "3df99bfe9696f5b0",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "a1da1314490cbef5",
            "isPostpaid": true
        },
        {
            "name": "مؤيد بدرالدين الامين احمد",
            "idNumber": 2493533406,
            "plateInfo": "رحم_6511_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-16",
            "createdDate": "2024-04-16T12:25:36.040Z",
            "mobileNumber": "542718783",
            "lastActionType": 1,
            "endDate": "2024-07-11T15:22:22.41",
            "sequenceNumber": 130512910,
            "startDate": "2024-04-16T15:22:22.41",
            "authorizationType": 1,
            "authorizationDays": 86,
            "authorizationNumber": 101445006799057,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "4d9d5e1f483d22e1",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "cd6f82b63081363b",
            "isPostpaid": true
        },
        {
            "name": "ناجي صلاح محمد على",
            "idNumber": 2494589969,
            "plateInfo": "بصب_2483_3",
            "canCancel": false,
            "canExtend": false,
            "issueDate": "2024-04-15",
            "createdDate": "2024-04-15T08:33:20.723Z",
            "mobileNumber": "563658737",
            "lastActionType": 3,
            "endDate": "2024-04-22T14:14:15.453",
            "sequenceNumber": 239318810,
            "startDate": "2024-04-15T11:32:39.52",
            "authorizationType": 1,
            "authorizationDays": 350,
            "authorizationNumber": 101445006768733,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "aba42cd884d0a2d9",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "41c145e7890ef768",
            "isPostpaid": true
        },
        {
            "name": "خالد على الخضر على",
            "idNumber": 2529218147,
            "plateInfo": "رحم_6493_1",
            "canCancel": false,
            "canExtend": false,
            "issueDate": "2024-04-14",
            "createdDate": "2024-04-14T10:32:29.520Z",
            "mobileNumber": "508407614",
            "lastActionType": 3,
            "endDate": "2024-05-01T14:40:50.36",
            "sequenceNumber": 151452910,
            "startDate": "2024-04-14T13:32:03.207",
            "authorizationType": 1,
            "authorizationDays": 233,
            "authorizationNumber": 101445006745692,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "489f69b938fffc54",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "188f5d7e3e6600fd",
            "isPostpaid": true
        },
        {
            "name": "MOHAMMAD TARIQ ZAMAN HAIDAR ZAMAN",
            "idNumber": 2519090266,
            "plateInfo": "بصص_1913_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-14",
            "createdDate": "2024-04-14T09:19:29.673Z",
            "mobileNumber": "595267757",
            "lastActionType": 1,
            "endDate": "2025-03-31T12:19:05.157",
            "sequenceNumber": 648057910,
            "startDate": "2024-04-14T12:19:05.157",
            "authorizationType": 1,
            "authorizationDays": 351,
            "authorizationNumber": 101445006744302,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "59bd5d0259fac416",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "600c9319d4e7fd14",
            "isPostpaid": true
        },
        {
            "name": "يحيى محمد محمد احمد الدواء",
            "idNumber": 2470742137,
            "plateInfo": "بطط_8468_3",
            "canCancel": false,
            "canExtend": false,
            "issueDate": "2024-04-14",
            "createdDate": "2024-04-14T09:07:09.610Z",
            "mobileNumber": "552659130",
            "lastActionType": 3,
            "endDate": "2024-04-24T12:43:23.94",
            "sequenceNumber": 794621020,
            "startDate": "2024-04-14T12:06:43.163",
            "authorizationType": 1,
            "authorizationDays": 351,
            "authorizationNumber": 101445006744054,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "de3588b22c0f761e",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "9396064149cbae44",
            "isPostpaid": true
        },
        {
            "name": "محمد سليمان احمد محمد احمد",
            "idNumber": 2548354675,
            "plateInfo": "بطط_8470_3",
            "canCancel": false,
            "canExtend": false,
            "issueDate": "2024-04-14",
            "createdDate": "2024-04-14T09:01:13.353Z",
            "mobileNumber": "559691245",
            "lastActionType": 3,
            "endDate": "2024-04-24T11:28:08.303",
            "sequenceNumber": 505621020,
            "startDate": "2024-04-14T11:59:45.84",
            "authorizationType": 1,
            "authorizationDays": 351,
            "authorizationNumber": 101445006743936,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "8e22dccee759bcd9",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "3cd1945cd8ed25cb",
            "isPostpaid": true
        },
        {
            "name": "الياس حسين بانقا يعقوب",
            "idNumber": 2507301493,
            "plateInfo": "بطط_8472_3",
            "canCancel": false,
            "canExtend": false,
            "issueDate": "2024-04-14",
            "createdDate": "2024-04-14T08:54:13.657Z",
            "mobileNumber": "582546828",
            "lastActionType": 3,
            "endDate": "2024-05-01T12:02:55.347",
            "sequenceNumber": 325621020,
            "startDate": "2024-04-14T11:53:22.373",
            "authorizationType": 1,
            "authorizationDays": 351,
            "authorizationNumber": 101445006743773,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "1d47b8385a552007",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "eaf24386fa677ca9",
            "isPostpaid": true
        },
        {
            "name": "وضاح بابكر محمد علي يوسف",
            "idNumber": 2527825125,
            "plateInfo": "بطط_8466_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-14",
            "createdDate": "2024-04-14T08:47:19.193Z",
            "mobileNumber": "557549329",
            "lastActionType": 1,
            "endDate": "2025-03-31T11:46:12.433",
            "sequenceNumber": 784621020,
            "startDate": "2024-04-14T11:46:12.433",
            "authorizationType": 1,
            "authorizationDays": 351,
            "authorizationNumber": 101445006743624,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "d8d9c32dbdb96a78",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "dc019fb32adb30b3",
            "isPostpaid": true
        },
        {
            "name": "خالد ابراهيم سالم سالم",
            "idNumber": 2498451737,
            "plateInfo": "رحم_6532_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-10",
            "createdDate": "2024-04-10T09:23:44.383Z",
            "mobileNumber": "509688545",
            "lastActionType": 1,
            "endDate": "2024-12-31T12:23:04.267",
            "sequenceNumber": 621512910,
            "startDate": "2024-04-10T12:23:04.267",
            "authorizationType": 1,
            "authorizationDays": 265,
            "authorizationNumber": 101445006690223,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2456028931,
            "traceId": "019a98565aaa6d81",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "03234314124edf27",
            "isPostpaid": true
        },
        {
            "name": "محمد احمد - حسن",
            "idNumber": 2006603605,
            "plateInfo": "رحن_4591_1",
            "canCancel": false,
            "canExtend": false,
            "issueDate": "2024-04-08",
            "createdDate": "2024-04-08T13:08:14.877Z",
            "mobileNumber": "569005588",
            "lastActionType": 3,
            "endDate": "2024-04-18T16:51:18.747",
            "sequenceNumber": 391862910,
            "startDate": "2024-04-08T16:07:57.657",
            "authorizationType": 1,
            "authorizationDays": 354,
            "authorizationNumber": 101445006641524,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "c7c5c4302d92f55d",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "1575e1c59782bb9c",
            "isPostpaid": true
        },
        {
            "name": "محمد احمد - حسن",
            "idNumber": 2006603605,
            "plateInfo": "رحم_6492_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-08",
            "createdDate": "2024-04-08T13:06:25.617Z",
            "mobileNumber": "569005588",
            "lastActionType": 1,
            "endDate": "2025-03-28T16:05:54.07",
            "sequenceNumber": 141452910,
            "startDate": "2024-04-08T16:05:54.07",
            "authorizationType": 1,
            "authorizationDays": 354,
            "authorizationNumber": 101445006641467,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "33816ccacd75bee2",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "f560a283f16f7984",
            "isPostpaid": true
        },
        {
            "name": "احمد الحاج على طه",
            "idNumber": 2476090036,
            "plateInfo": "رحط_8302_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-07",
            "createdDate": "2024-04-07T09:27:23.880Z",
            "mobileNumber": "504407849",
            "lastActionType": 1,
            "endDate": "2025-03-27T12:27:05.133",
            "sequenceNumber": 245512910,
            "startDate": "2024-04-07T12:27:05.133",
            "authorizationType": 1,
            "authorizationDays": 354,
            "authorizationNumber": 101445006611472,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "3568432102bd67b6",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "3bc79d338dbe48be",
            "isPostpaid": true
        },
        {
            "name": "محمد محسن محمد صلاح",
            "idNumber": 2529534485,
            "plateInfo": "بصب_2489_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-07",
            "createdDate": "2024-04-07T08:38:30.630Z",
            "mobileNumber": "554325047",
            "lastActionType": 1,
            "endDate": "2024-12-31T11:34:47.69",
            "sequenceNumber": 678318810,
            "startDate": "2024-04-07T11:34:47.69",
            "authorizationType": 1,
            "authorizationDays": 268,
            "authorizationNumber": 101445006610685,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2456028931,
            "traceId": "ae1fcd33e19e93d6",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "3412e53401a3e8a7",
            "isPostpaid": true
        },
        {
            "name": "سامي عبدالله عوض السلطان",
            "idNumber": 2379131838,
            "plateInfo": "رحر_7452_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-07",
            "createdDate": "2024-04-07T08:38:18.253Z",
            "mobileNumber": "553859121",
            "lastActionType": 1,
            "endDate": "2024-10-08T11:37:47.3",
            "sequenceNumber": 429112910,
            "startDate": "2024-04-07T11:37:47.3",
            "authorizationType": 1,
            "authorizationDays": 184,
            "authorizationNumber": 101445006610681,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "e3fc16dc30693e60",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "76906d6a99a1c30c",
            "isPostpaid": true
        },
        {
            "name": "MESHAL HABEEB AZIMULLAH ABDULGADER",
            "idNumber": 2544991660,
            "plateInfo": "بصب_8233_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-07",
            "createdDate": "2024-04-07T08:30:03.403Z",
            "mobileNumber": "590047608",
            "lastActionType": 1,
            "endDate": "2024-12-31T11:28:23.927",
            "sequenceNumber": 944700910,
            "startDate": "2024-04-07T11:28:23.927",
            "authorizationType": 1,
            "authorizationDays": 268,
            "authorizationNumber": 101445006610576,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2456028931,
            "traceId": "a74117ad153cb46c",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "f6a53f594b4feda8",
            "isPostpaid": true
        },
        {
            "name": "محمد بشير محمد حامد",
            "idNumber": 2456948948,
            "plateInfo": "بعأ_1021_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-07",
            "createdDate": "2024-04-07T08:22:56.343Z",
            "mobileNumber": "551359159",
            "lastActionType": 1,
            "endDate": "2025-03-27T11:21:09.677",
            "sequenceNumber": 932746020,
            "startDate": "2024-04-07T11:21:09.677",
            "authorizationType": 1,
            "authorizationDays": 354,
            "authorizationNumber": 101445006610476,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "c47bc5f734c0ffb0",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "b0dd57d8e8a3d504",
            "isPostpaid": true
        },
        {
            "name": "ABDULWAHAB MADAHER AHMED",
            "idNumber": 2544353861,
            "plateInfo": "بعأ_1912_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-07",
            "createdDate": "2024-04-07T08:20:32.223Z",
            "mobileNumber": "577919672",
            "lastActionType": 1,
            "endDate": "2024-12-31T11:19:48.063",
            "sequenceNumber": 674746020,
            "startDate": "2024-04-07T11:19:48.063",
            "authorizationType": 1,
            "authorizationDays": 268,
            "authorizationNumber": 101445006610449,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2456028931,
            "traceId": "f630bae90d66ed24",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "12820c391aed0d19",
            "isPostpaid": true
        },
        {
            "name": "محمد عصام بشير محمد",
            "idNumber": 2443532581,
            "plateInfo": "بسن_4975_3",
            "canCancel": false,
            "canExtend": false,
            "issueDate": "2024-04-06",
            "createdDate": "2024-04-06T10:31:56.230Z",
            "mobileNumber": "581516187",
            "lastActionType": 3,
            "endDate": "2024-04-21T09:59:35.003",
            "sequenceNumber": 963738810,
            "startDate": "2024-04-06T13:27:51.68",
            "authorizationType": 1,
            "authorizationDays": 24,
            "authorizationNumber": 101445006590480,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "bb8e1af5dc6fce53",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "49c6f5ebdea34e44",
            "isPostpaid": true
        },
        {
            "name": "محمد الفاتح محمود الدباغ",
            "idNumber": 2032384337,
            "plateInfo": "بصب_8225_3",
            "canCancel": false,
            "canExtend": false,
            "issueDate": "2024-04-06",
            "createdDate": "2024-04-06T10:26:17.260Z",
            "mobileNumber": "542937929",
            "lastActionType": 3,
            "endDate": "2024-04-21T14:40:11.127",
            "sequenceNumber": 353700910,
            "startDate": "2024-04-30T13:25:29.123",
            "authorizationType": 1,
            "authorizationDays": 31,
            "authorizationNumber": 101445006590406,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "2aa5a0a7d4b0caa7",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "17274e9001e88510",
            "isPostpaid": true
        },
        {
            "name": "SHEIKH NUR ABDI HAJI OSMAN",
            "idNumber": 2374879779,
            "plateInfo": "رحط_8307_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-06",
            "createdDate": "2024-04-05T21:30:35.360Z",
            "mobileNumber": "575509970",
            "lastActionType": 1,
            "endDate": "2024-12-31T00:29:54.397",
            "sequenceNumber": 685512910,
            "startDate": "2024-04-06T00:29:54.397",
            "authorizationType": 1,
            "authorizationDays": 269,
            "authorizationNumber": 101445006584953,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2068943584,
            "traceId": "8e4ccda39650050c",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "df72ce4e2887e3c3",
            "isPostpaid": true
        },
        {
            "name": "محمد يونس ادم علي",
            "idNumber": 2383099336,
            "plateInfo": "رحر_7456_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-06",
            "createdDate": "2024-04-05T21:13:20.957Z",
            "mobileNumber": "544007036",
            "lastActionType": 1,
            "endDate": "2024-12-01T00:11:59.837",
            "sequenceNumber": 820212910,
            "startDate": "2024-04-06T00:11:59.837",
            "authorizationType": 1,
            "authorizationDays": 239,
            "authorizationNumber": 101445006584584,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2068943584,
            "traceId": "69c835eadb182824",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "30c06cfd7c1f6057",
            "isPostpaid": true
        },
        {
            "name": "عمرو سيد عبد العال محمد",
            "idNumber": 2521807517,
            "plateInfo": "رحم_6540_1",
            "canCancel": false,
            "canExtend": false,
            "issueDate": "2024-04-04",
            "createdDate": "2024-04-04T15:40:47.680Z",
            "mobileNumber": "540670068",
            "lastActionType": 3,
            "endDate": "2024-04-30T15:11:57",
            "sequenceNumber": 332512910,
            "startDate": "2024-04-04T18:39:45.877",
            "authorizationType": 1,
            "authorizationDays": 271,
            "authorizationNumber": 101445006560710,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2068943584,
            "traceId": "099fe3b0eacbadd4",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "1835d9aafcf291ea",
            "isPostpaid": true
        },
        {
            "name": "ANAS HAMED ABKAR AHMED",
            "idNumber": 2161934316,
            "plateInfo": "رحر_7455_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-04",
            "createdDate": "2024-04-04T14:59:18.503Z",
            "mobileNumber": "547978390",
            "lastActionType": 1,
            "endDate": "2024-12-31T17:58:43.817",
            "sequenceNumber": 10212910,
            "startDate": "2024-04-04T17:58:43.817",
            "authorizationType": 1,
            "authorizationDays": 271,
            "authorizationNumber": 101445006560389,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2068943584,
            "traceId": "b2ec8543b73dd7c9",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "6e685ce027d7ab7c",
            "isPostpaid": true
        },
        {
            "name": "محمد عثمان محمدالظافر عثمان حسن",
            "idNumber": 2479604635,
            "plateInfo": "بصس_3551_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-04",
            "createdDate": "2024-04-04T11:27:21.490Z",
            "mobileNumber": "555431347",
            "lastActionType": 1,
            "endDate": "2024-11-19T14:26:47.4",
            "sequenceNumber": 541290910,
            "startDate": "2024-04-04T14:26:47.4",
            "authorizationType": 1,
            "authorizationDays": 229,
            "authorizationNumber": 101445006554494,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "3d31111d3023e9ee",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "189e3a194c9cf4ec",
            "isPostpaid": true
        },
        {
            "name": "محمد قسم السيد سعيد فرح الله",
            "idNumber": 2508935174,
            "plateInfo": "بصب_8246_3",
            "canCancel": false,
            "canExtend": false,
            "issueDate": "2024-04-03",
            "createdDate": "2024-04-03T11:53:30.250Z",
            "mobileNumber": "561275433",
            "lastActionType": 3,
            "endDate": "2024-04-17T10:51:21.987",
            "sequenceNumber": 246700910,
            "startDate": "2024-04-03T14:52:58.327",
            "authorizationType": 1,
            "authorizationDays": 354,
            "authorizationNumber": 101445006529461,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "a2e5e4c1cf9b94f0",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "f654f0288d62c9cf",
            "isPostpaid": true
        },
        {
            "name": "ابوبكر الياس علي محمد",
            "idNumber": 2492109034,
            "plateInfo": "بصب_8241_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-03",
            "createdDate": "2024-04-03T11:37:05.830Z",
            "mobileNumber": "577513430",
            "lastActionType": 1,
            "endDate": "2025-03-23T14:35:17.683",
            "sequenceNumber": 895700910,
            "startDate": "2024-04-03T14:35:17.683",
            "authorizationType": 1,
            "authorizationDays": 354,
            "authorizationNumber": 101445006528933,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "7238fc36bd9e1341",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "bcbf77a122af3cc2",
            "isPostpaid": true
        },
        {
            "name": "جعفر محمد النيل عبدالفتاح",
            "idNumber": 2529901486,
            "plateInfo": "بعأ_1025_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-03",
            "createdDate": "2024-04-03T11:23:01.987Z",
            "mobileNumber": "555469532",
            "lastActionType": 1,
            "endDate": "2024-10-24T14:21:05.027",
            "sequenceNumber": 92746020,
            "startDate": "2024-04-03T14:21:05.027",
            "authorizationType": 1,
            "authorizationDays": 204,
            "authorizationNumber": 101445006528500,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "42d02250e6cd8142",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "990c13c7d5238900",
            "isPostpaid": true
        },
        {
            "name": "احمد محمد يحيى جباره",
            "idNumber": 2539613634,
            "plateInfo": "بعأ_1026_3",
            "canCancel": false,
            "canExtend": false,
            "issueDate": "2024-04-03",
            "createdDate": "2024-04-03T10:57:55.373Z",
            "mobileNumber": "533188642",
            "lastActionType": 3,
            "endDate": "2024-04-17T11:15:28.277",
            "sequenceNumber": 692746020,
            "startDate": "2024-04-03T13:56:56.113",
            "authorizationType": 1,
            "authorizationDays": 354,
            "authorizationNumber": 101445006527730,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "b5542ea0ceb4f6ce",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "818c7906d935a893",
            "isPostpaid": true
        },
        {
            "name": "محمد صالح سالم عبدالشيخ",
            "idNumber": 2111589103,
            "plateInfo": "رحم_6572_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-02",
            "createdDate": "2024-04-02T17:13:43.123Z",
            "mobileNumber": "507357144",
            "lastActionType": 1,
            "endDate": "2024-12-31T20:12:35.007",
            "sequenceNumber": 671512910,
            "startDate": "2024-04-02T20:12:35.007",
            "authorizationType": 1,
            "authorizationDays": 273,
            "authorizationNumber": 101445006510026,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2068943584,
            "traceId": "4dcaa91047a373d4",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "31539ba161a45878",
            "isPostpaid": true
        },
        {
            "name": "محمد عبدالواحد ادريس عوض الله",
            "idNumber": 2530169305,
            "plateInfo": "بعأ_1024_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-02",
            "createdDate": "2024-04-02T13:18:17.253Z",
            "mobileNumber": "533400650",
            "lastActionType": 1,
            "endDate": "2025-03-22T16:17:02.497",
            "sequenceNumber": 472746020,
            "startDate": "2024-04-02T16:17:02.497",
            "authorizationType": 1,
            "authorizationDays": 354,
            "authorizationNumber": 101445006507071,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "2c874204e0982611",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "3afe0ab6c829d053",
            "isPostpaid": true
        },
        {
            "name": "معاذ عزالدين عبدالحليم الماحى",
            "idNumber": 2422014759,
            "plateInfo": "بعأ_1027_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-02",
            "createdDate": "2024-04-02T13:12:03.600Z",
            "mobileNumber": "535097817",
            "lastActionType": 1,
            "endDate": "2025-03-22T16:08:25.637",
            "sequenceNumber": 403746020,
            "startDate": "2024-04-02T16:08:25.637",
            "authorizationType": 1,
            "authorizationDays": 354,
            "authorizationNumber": 101445006506933,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "02fec55706690e1d",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "f9c1f2c8e3b69ae9",
            "isPostpaid": true
        },
        {
            "name": "جعفر حامد جعفر حامد",
            "idNumber": 2464530068,
            "plateInfo": "بعأ_1916_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-02",
            "createdDate": "2024-04-02T12:57:29.150Z",
            "mobileNumber": "553404759",
            "lastActionType": 1,
            "endDate": "2024-12-26T15:56:43.033",
            "sequenceNumber": 615746020,
            "startDate": "2024-04-02T15:56:43.033",
            "authorizationType": 1,
            "authorizationDays": 268,
            "authorizationNumber": 101445006506585,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "b9b31de57b60ff31",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "af6f75c4ab59581e",
            "isPostpaid": true
        },
        {
            "name": "SHAHER YAR BASHIR AHMAD",
            "idNumber": 2545246155,
            "plateInfo": "بعأ_1915_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-02",
            "createdDate": "2024-04-02T12:27:26.443Z",
            "mobileNumber": "572784064",
            "lastActionType": 1,
            "endDate": "2025-03-22T15:23:55.907",
            "sequenceNumber": 905746020,
            "startDate": "2024-04-02T15:23:55.907",
            "authorizationType": 1,
            "authorizationDays": 354,
            "authorizationNumber": 101445006505785,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "ca2b75c608848157",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "ccb5dbeb337298d9",
            "isPostpaid": true
        },
        {
            "name": "النزير حامد عبدالله عوض الله",
            "idNumber": 2536240092,
            "plateInfo": "بعأ_1023_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-02",
            "createdDate": "2024-04-02T12:08:16.167Z",
            "mobileNumber": "532466088",
            "lastActionType": 1,
            "endDate": "2025-03-22T15:06:36.937",
            "sequenceNumber": 862746020,
            "startDate": "2024-04-02T15:06:36.937",
            "authorizationType": 1,
            "authorizationDays": 354,
            "authorizationNumber": 101445006505230,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "918bc5c4d99b8391",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "684037d558160a85",
            "isPostpaid": true
        },
        {
            "name": "سمير حمود قائد منصور",
            "idNumber": 2440959514,
            "plateInfo": "بعأ_1902_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-02",
            "createdDate": "2024-04-02T11:59:12.107Z",
            "mobileNumber": "577378126",
            "lastActionType": 1,
            "endDate": "2025-03-22T14:58:24.783",
            "sequenceNumber": 733746020,
            "startDate": "2024-04-02T14:58:24.783",
            "authorizationType": 1,
            "authorizationDays": 354,
            "authorizationNumber": 101445006504972,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "2e9bafb851a0c27e",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "e96d1feca2e25d09",
            "isPostpaid": true
        },
        {
            "name": "بدر عبده محمد السدره",
            "idNumber": 2366289151,
            "plateInfo": "بعأ_1903_3",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-02",
            "createdDate": "2024-04-02T07:31:52.030Z",
            "mobileNumber": "502909884",
            "lastActionType": 1,
            "endDate": "2024-07-31T10:31:23.817",
            "sequenceNumber": 743746020,
            "startDate": "2024-04-02T10:31:23.817",
            "authorizationType": 1,
            "authorizationDays": 120,
            "authorizationNumber": 101445006498479,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2456028931,
            "traceId": "50fd96c2099ba0ad",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "dd2908bf52f4b501",
            "isPostpaid": true
        },
        {
            "name": "الغزالي محمدين محمد ادم",
            "idNumber": 2540070105,
            "plateInfo": "رحم_6495_1",
            "canCancel": true,
            "canExtend": false,
            "issueDate": "2024-04-01",
            "createdDate": "2024-04-01T13:08:34.447Z",
            "mobileNumber": "562913719",
            "lastActionType": 1,
            "endDate": "2025-03-21T16:05:44.97",
            "sequenceNumber": 681452910,
            "startDate": "2024-04-01T16:05:44.97",
            "authorizationType": 1,
            "authorizationDays": 354,
            "authorizationNumber": 101445006481729,
            "allowedCountriesList": [],
            "branchName": {
                "ar": "الفرع الرئيسي",
                "en": "hq branch"
            },
            "createdUserIdNumber": 2467524100,
            "traceId": "2bca09641697823b",
            "issuedFromTamm": true,
            "isVisitor": false,
            "visitorDocumentNumber": null,
            "visitorNationalityCode": null,
            "visitorEmail": null,
            "operationId": "f72755dd4c447116",
            "isPostpaid": true
        }
    ]';
    $report_data = json_decode($report_data);
    $paltes;
    foreach($report_data as $iteem){
       
      $plate_chart = $iteem->plateInfo[2].$iteem->plateInfo[3].$iteem->plateInfo[5].$iteem->plateInfo[6];
      $plate_num = "";
      $var = $iteem->plateInfo;
       
      $paltes[] = $iteem->plateInfo; 
    }
    $var1 = $paltes[0];
    dd($var1);
  }
  public function newVehiclesUpdates(){
    $payload = '[
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 2482,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "رينو",
            "model": "فان",
            "year": 2021
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8230,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8235,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 2471,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "رينو",
            "model": "فان",
            "year": 2021
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 2446,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "رينو",
            "model": "فان",
            "year": 2021
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 2484,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "رينو",
            "model": "فان",
            "year": 2021
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 2478,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "رينو",
            "model": "فان",
            "year": 2021
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8248,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 2479,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "رينو",
            "model": "فان",
            "year": 2021
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 2474,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "رينو",
            "model": "فان",
            "year": 2021
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8243,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 3192,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "فان بضاعه",
            "year": 2021
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8271,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 2483,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "رينو",
            "model": "فان",
            "year": 2021
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8245,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8267,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8229,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8261,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8246,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8268,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 2450,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "رينو",
            "model": "فان",
            "year": 2021
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 2435,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "رينو",
            "model": "فان",
            "year": 2021
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8262,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8274,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8244,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 2448,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "رينو",
            "model": "فان",
            "year": 2021
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8225,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 2473,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "رينو",
            "model": "فان",
            "year": 2021
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8266,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8242,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 2486,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "رينو",
            "model": "فان",
            "year": 2021
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8238,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8247,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8257,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "س",
            "number": 3551,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "رينو",
            "model": "فان",
            "year": 2021
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ك",
            "number": 4876,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "فان بضاعه",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8253,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 2477,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "رينو",
            "model": "فان",
            "year": 2021
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ص",
            "number": 1913,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "اورفان",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 2489,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "رينو",
            "model": "فان",
            "year": 2021
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },{
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8232,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ص",
            "number": 1905,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "اورفان",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8258,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8256,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8273,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8228,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 2488,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "رينو",
            "model": "فان",
            "year": 2021
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 2481,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "رينو",
            "model": "فان",
            "year": 2021
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 2475,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "رينو",
            "model": "فان",
            "year": 2021
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8234,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 2480,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "رينو",
            "model": "فان",
            "year": 2021
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8249,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8240,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 2472,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "رينو",
            "model": "فان",
            "year": 2021
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8270,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8239,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8259,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8227,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8263,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8241,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },{
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8251,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 2449,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "رينو",
            "model": "فان",
            "year": 2021
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8254,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8233,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 2487,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "رينو",
            "model": "فان",
            "year": 2021
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ص",
            "text3": "ب",
            "number": 8237,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "بكس 404",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجزيرة لتأجير السيارات",
            "en": "J R C"
            },
            "ownerIdNumber": 7001364939,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4966,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4973,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4984,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4981,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4969,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4968,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4970,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4982,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4967,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4971,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4978,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4983,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4965,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4974,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4969,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4968,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4970,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4982,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4967,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4971,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4978,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4983,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4965,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4974,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4975,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "س",
            "text3": "ن",
            "number": 4976,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "بيجو",
            "model": "فان",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الجبر لتأجير السيارات",
            "en": "Al - Jabbar Rent A Car Company"
            },
            "ownerIdNumber": 7007537371,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6497,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ر",
            "number": 7455,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5437,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ط",
            "number": 8320,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ر",
            "number": 7457,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6510,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5438,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6538,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5432,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6459,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5448,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5156,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5078,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5443,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ط",
            "text3": "ط",
            "number": 8469,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "اورفان",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6509,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6511,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ط",
            "number": 8323,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6492,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6534,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6493,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5430,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6430,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ن",
            "number": 4357,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6569,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5079,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6491,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6517,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ط",
            "number": 8302,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6574,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5434,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6431,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ن",
            "number": 4551,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ر",
            "number": 7453,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6530,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ط",
            "number": 8310,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6536,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5450,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ط",
            "text3": "ط",
            "number": 8472,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "اورفان",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6540,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5433,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6513,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6489,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ر",
            "number": 7499,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6462,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6516,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6496,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ن",
            "number": 4591,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ط",
            "text3": "ط",
            "number": 8467,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "اورفان",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ط",
            "number": 8308,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ر",
            "number": 7454,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ط",
            "number": 8321,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ر",
            "number": 7452,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ط",
            "number": 8301,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6546,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6514,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5158,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ط",
            "text3": "ط",
            "number": 8470,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "اورفان",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6531,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ط",
            "number": 8322,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6533,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6461,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ن",
            "number": 4356,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ط",
            "number": 8306,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6535,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ر",
            "number": 7500,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5440,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6532,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ر",
            "number": 7460,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6460,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6487,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6572,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6220,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6515,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6495,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ط",
            "number": 8307,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6570,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6490,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5439,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ط",
            "text3": "ط",
            "number": 8471,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "اورفان",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5441,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6512,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5442,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6543,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ر",
            "number": 7458,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5447,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6573,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ط",
            "number": 8305,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ر",
            "number": 7472,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6571,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ط",
            "text3": "ط",
            "number": 8466,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "اورفان",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5152,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ب",
            "text2": "ط",
            "text3": "ط",
            "number": 8468,
            "type": {
            "code": 3,
            "nameAr": "نقل خاص",
            "nameEn": "Private Transport"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "اورفان",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ط",
            "number": 8309,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6537,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ر",
            "number": 7456,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ن",
            "number": 4355,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5431,
            "type": {
            "code": 1,
            "nameAr": "خاص",
            "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ط",
            "number": 8304,
            "type": {
                "code": 1,
                "nameAr": "خاص",
                "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5157,
            "type": {
                "code": 1,
                "nameAr": "خاص",
                "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6432,
            "type": {
                "code": 1,
                "nameAr": "خاص",
                "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5154,
            "type": {
                "code": 1,
                "nameAr": "خاص",
                "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5446,
            "type": {
                "code": 1,
                "nameAr": "خاص",
                "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ر",
            "number": 7498,
            "type": {
                "code": 1,
                "nameAr": "خاص",
                "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5436,
            "type": {
                "code": 1,
                "nameAr": "خاص",
                "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "ط",
            "number": 8311,
            "type": {
                "code": 1,
                "nameAr": "خاص",
                "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ص",
            "text3": "ن",
            "number": 5449,
            "type": {
                "code": 1,
                "nameAr": "خاص",
                "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "كيا",
            "model": "بيجاس",
            "year": 2023
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
            "text1": "ر",
            "text2": "ح",
            "text3": "م",
            "number": 6539,
            "type": {
                "code": 1,
                "nameAr": "خاص",
                "nameEn": "Private Car"
            }
            },
            "branchName": null,
            "makerAndModel": {
            "maker": "نيسان",
            "model": "صني",
            "year": 2022
            },
            "ownerName": {
            "ar": "شركة الراجحي المصرفية للأستثمار",
            "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
                "text1": "ر",
                "text2": "ح",
                "text3": "ط",
                "number": 8303,
                "type": {
                    "code": 1,
                    "nameAr": "خاص",
                    "nameEn": "Private Car"
                }
            },
            "branchName": null,
            "makerAndModel": {
                "maker": "نيسان",
                "model": "صني",
                "year": 2022
            },
            "ownerName": {
                "ar": "شركة الراجحي المصرفية للأستثمار",
                "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
                "text1": "ر",
                "text2": "س",
                "text3": "ي",
                "number": 8000,
                "type": {
                    "code": 1,
                    "nameAr": "خاص",
                    "nameEn": "Private Car"
                }
            },
            "branchName": null,
            "makerAndModel": {
                "maker": "لاندروفر",
                "model": "رانج روفر",
                "year": 2023
            },
            "ownerName": {
                "ar": "شركة الراجحي المصرفية للأستثمار",
                "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
                "text1": "ر",
                "text2": "ح",
                "text3": "م",
                "number": 6494,
                "type": {
                    "code": 1,
                    "nameAr": "خاص",
                    "nameEn": "Private Car"
                }
            },
            "branchName": null,
            "makerAndModel": {
                "maker": "نيسان",
                "model": "صني",
                "year": 2022
            },
            "ownerName": {
                "ar": "شركة الراجحي المصرفية للأستثمار",
                "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
                "text1": "ر",
                "text2": "ص",
                "text3": "ن",
                "number": 5435,
                "type": {
                    "code": 1,
                    "nameAr": "خاص",
                    "nameEn": "Private Car"
                }
            },
            "branchName": null,
            "makerAndModel": {
                "maker": "كيا",
                "model": "بيجاس",
                "year": 2023
            },
            "ownerName": {
                "ar": "شركة الراجحي المصرفية للأستثمار",
                "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
                "text1": "ب",
                "text2": "ع",
                "text3": "أ",
                "number": 1026,
                "type": {
                    "code": 3,
                    "nameAr": "نقل خاص",
                    "nameEn": "Private Transport"
                }
            },
            "branchName": null,
            "makerAndModel": {
                "maker": "بيجو",
                "model": "فان",
                "year": 2024
            },
            "ownerName": {
                "ar": "شركة الراجحي المصرفية للأستثمار",
                "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
                "text1": "ب",
                "text2": "ع",
                "text3": "أ",
                "number": 1912,
                "type": {
                    "code": 3,
                    "nameAr": "نقل خاص",
                    "nameEn": "Private Transport"
                }
            },
            "branchName": null,
            "makerAndModel": {
                "maker": "بيجو",
                "model": "فان",
                "year": 2024
            },
            "ownerName": {
                "ar": "شركة الراجحي المصرفية للأستثمار",
                "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
                "text1": "ب",
                "text2": "ع",
                "text3": "أ",
                "number": 1908,
                "type": {
                    "code": 3,
                    "nameAr": "نقل خاص",
                    "nameEn": "Private Transport"
                }
            },
            "branchName": null,
            "makerAndModel": {
                "maker": "بيجو",
                "model": "فان",
                "year": 2024
            },
            "ownerName": {
                "ar": "شركة الراجحي المصرفية للأستثمار",
                "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
                "text1": "ب",
                "text2": "ع",
                "text3": "أ",
                "number": 1913,
                "type": {
                    "code": 3,
                    "nameAr": "نقل خاص",
                    "nameEn": "Private Transport"
                }
            },
            "branchName": null,
            "makerAndModel": {
                "maker": "بيجو",
                "model": "فان",
                "year": 2024
            },
            "ownerName": {
                "ar": "شركة الراجحي المصرفية للأستثمار",
                "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
                "text1": "ب",
                "text2": "ع",
                "text3": "أ",
                "number": 1021,
                "type": {
                    "code": 3,
                    "nameAr": "نقل خاص",
                    "nameEn": "Private Transport"
                }
            },
            "branchName": null,
            "makerAndModel": {
                "maker": "بيجو",
                "model": "فان",
                "year": 2024
            },
            "ownerName": {
                "ar": "شركة الراجحي المصرفية للأستثمار",
                "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            {
            "plate": {
                "text1": "ب",
                "text2": "ع",
                "text3": "أ",
                "number": 1025,
                "type": {
                    "code": 3,
                    "nameAr": "نقل خاص",
                    "nameEn": "Private Transport"
                }
            },
            "branchName": null,
            "makerAndModel": {
                "maker": "بيجو",
                "model": "فان",
                "year": 2024
            },
            "ownerName": {
                "ar": "شركة الراجحي المصرفية للأستثمار",
                "en": "ALRAJHI BANK"
            },
            "ownerIdNumber": 7000102744,
            "actualDriverId": 7016327863
            },
            
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ع",
                    "text3": "أ",
                    "number": 1906,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2024
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ع",
                    "text3": "أ",
                    "number": 1915,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2024
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ع",
                    "text3": "أ",
                    "number": 1027,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2024
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ع",
                    "text3": "أ",
                    "number": 1909,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2024
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ع",
                    "text3": "أ",
                    "number": 1901,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2024
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ع",
                    "text3": "أ",
                    "number": 1911,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2024
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ع",
                    "text3": "أ",
                    "number": 1022,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2024
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ع",
                    "text3": "أ",
                    "number": 1023,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2024
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ع",
                    "text3": "أ",
                    "number": 1905,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2024
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ع",
                    "text3": "أ",
                    "number": 1902,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2024
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
                {
                    "plate": {
                        "text1": "ب",
                        "text2": "ع",
                        "text3": "أ",
                        "number": 1916,
                        "type": {
                            "code": 3,
                            "nameAr": "نقل خاص",
                            "nameEn": "Private Transport"
                        }
                    },
                    "branchName": null,
                    "makerAndModel": {
                        "maker": "بيجو",
                        "model": "فان",
                        "year": 2024
                    },
                    "ownerName": {
                        "ar": "شركة الراجحي المصرفية للأستثمار",
                        "en": "ALRAJHI BANK"
                    },
                    "ownerIdNumber": 7000102744,
                    "actualDriverId": 7016327863
                },
                {
                    "plate": {
                        "text1": "ب",
                        "text2": "ع",
                        "text3": "أ",
                        "number": 1903,
                        "type": {
                            "code": 3,
                            "nameAr": "نقل خاص",
                            "nameEn": "Private Transport"
                        }
                    },
                    "branchName": null,
                    "makerAndModel": {
                        "maker": "بيجو",
                        "model": "فان",
                        "year": 2024
                    },
                    "ownerName": {
                        "ar": "شركة الراجحي المصرفية للأستثمار",
                        "en": "ALRAJHI BANK"
                    },
                    "ownerIdNumber": 7000102744,
                    "actualDriverId": 7016327863
                },
                {
                    "plate": {
                        "text1": "ب",
                        "text2": "ع",
                        "text3": "أ",
                        "number": 1904,
                        "type": {
                            "code": 3,
                            "nameAr": "نقل خاص",
                            "nameEn": "Private Transport"
                        }
                    },
                    "branchName": null,
                    "makerAndModel": {
                        "maker": "بيجو",
                        "model": "فان",
                        "year": 2024
                    },
                    "ownerName": {
                        "ar": "شركة الراجحي المصرفية للأستثمار",
                        "en": "ALRAJHI BANK"
                    },
                    "ownerIdNumber": 7000102744,
                    "actualDriverId": 7016327863
                },
                {
                    "plate": {
                        "text1": "ب",
                        "text2": "ع",
                        "text3": "أ",
                        "number": 1907,
                        "type": {
                            "code": 3,
                            "nameAr": "نقل خاص",
                            "nameEn": "Private Transport"
                        }
                    },
                    "branchName": null,
                    "makerAndModel": {
                        "maker": "بيجو",
                        "model": "فان",
                        "year": 2024
                    },
                    "ownerName": {
                        "ar": "شركة الراجحي المصرفية للأستثمار",
                        "en": "ALRAJHI BANK"
                    },
                    "ownerIdNumber": 7000102744,
                    "actualDriverId": 7016327863
                },
                {
                    "plate": {
                        "text1": "ب",
                        "text2": "ع",
                        "text3": "أ",
                        "number": 1914,
                        "type": {
                            "code": 3,
                            "nameAr": "نقل خاص",
                            "nameEn": "Private Transport"
                        }
                    },
                    "branchName": null,
                    "makerAndModel": {
                        "maker": "بيجو",
                        "model": "فان",
                        "year": 2024
                    },
                    "ownerName": {
                        "ar": "شركة الراجحي المصرفية للأستثمار",
                        "en": "ALRAJHI BANK"
                    },
                    "ownerIdNumber": 7000102744,
                    "actualDriverId": 7016327863
                },
                {
                    "plate": {
                        "text1": "ب",
                        "text2": "ع",
                        "text3": "أ",
                        "number": 1024,
                        "type": {
                            "code": 3,
                            "nameAr": "نقل خاص",
                            "nameEn": "Private Transport"
                        }
                    },
                    "branchName": null,
                    "makerAndModel": {
                        "maker": "بيجو",
                        "model": "فان",
                        "year": 2024
                    },
                    "ownerName": {
                        "ar": "شركة الراجحي المصرفية للأستثمار",
                        "en": "ALRAJHI BANK"
                    },
                    "ownerIdNumber": 7000102744,
                    "actualDriverId": 7016327863
                },
                {
                    "plate": {
                        "text1": "ب",
                        "text2": "ع",
                        "text3": "أ",
                        "number": 1910,
                        "type": {
                            "code": 3,
                            "nameAr": "نقل خاص",
                            "nameEn": "Private Transport"
                        }
                    },
                    "branchName": null,
                    "makerAndModel": {
                        "maker": "بيجو",
                        "model": "فان",
                        "year": 2024
                    },
                    "ownerName": {
                        "ar": "شركة الراجحي المصرفية للأستثمار",
                        "en": "ALRAJHI BANK"
                    },
                    "ownerIdNumber": 7000102744,
                    "actualDriverId": 7016327863
                }
      ]';

      $payload = json_decode($payload);
      $vehiclesList;
      foreach($payload as $count=>$item){
         
        $plate = $item->plate;
        
        $makerAndModel = $item->makerAndModel;
        $ownerName = $item->ownerName;
        $maker = $makerAndModel->maker.' '.$makerAndModel->model.' '.$makerAndModel->year;
         
        
        $fullPlate = $plate->number.' '.$plate->text1.' '.$plate->text2.' '.$plate->text3.' ';
        // dd($maker);
        $type = $plate->type; 
        $vehiclesList[] = [
          "plate"=>$fullPlate,
          "registration_type"=>$type->nameAr,
          "model"=>$maker,
          "owner"=>$ownerName->ar
        ]; 
      } 
      $html = "<table>";
      foreach ($vehiclesList as $iitemms) {
        # code...
        $html = $html." 
        <tr>
          <td>".$iitemms['model']."</td>
          <td>".$iitemms['plate']."</td>
          <td>".$iitemms['registration_type']."</td>
          <td>".$iitemms['owner']."</td>
        </tr> 
        "; 
      }
      echo $html.' </table>';
    }
  public function New_Design(){
    return view('layout2');
  }
  public function other_recored(){
    $LM_drivers = DB::select("SELECT * FROM `drivers` WHERE warehouseId in (293,295,289,274,290,282,275);"); //293,295,289,274,290,282,275
    $drivers;
    
    foreach($LM_drivers as $da){
        $payload = DB::select("SELECT id,driverId FROM `packages_report` WHERE `driverId`=".$da->id." "); 
        if(count($payload)>0){ 
          $drivers[] = [
              "driver_id"=>$da->id,
              "job_id"=>$da->job_id,
              "jpurnal_item"=>$payload
          ];
        }else{

        }
         
    }
    // dd($drivers);
    return response()->json([$drivers],200);
  }
    public function getDAJournals($driver_id){ 
        $payload = DB::select("SELECT * FROM `journal` WHERE driverId=".$driver_id." ");
        return response()->json(['status'=>true,'payload'=>$payload],200);
    }
    public function SendHttpTpVps(){ 
        $LM_drivers = DB::select("SELECT * FROM `drivers` WHERE warehouseId in (293,295,289,274,290,282,275);"); //293,295,289,274,290,282,275
        $drivers;
        
        foreach($LM_drivers as $da){
            $payload = DB::select("SELECT id FROM `journal` WHERE driverId=".$da->id." ");
            $drivers[] = [
                "driver_id"=>$da->id,
                "jpurnal_item"=>$payload
            ]; 
        }
        return response()->json([$drivers],200);
        
        dd("SendHttpTpVps"); 
        
        return view('FixingLandmark',compact('LM_drivers'));
        
    }
    public function apiLandmark_yyyh(){
        $payload = '[
            {
              "DA": "LM0033",
              "job_id": 9060,
              "items": [
                {
                  "journal_id": 46011,
                  "journal_type": 6,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "F_BTC_134",
              "job_id": 9402,
              "items": [
                {
                  "journal_id": 51604,
                  "journal_type": 1,
                  "post_id": 7382
                },
                {
                  "journal_id": 53617,
                  "journal_type": 1,
                  "post_id": 7772
                },
                {
                  "journal_id": 55258,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 55329,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 56251,
                  "journal_type": 9,
                  "post_id": 8266
                },
                {
                  "journal_id": 56280,
                  "journal_type": 1,
                  "post_id": 8271
                },
                {
                  "journal_id": 56462,
                  "journal_type": 9,
                  "post_id": 8621
                },
                {
                  "journal_id": 56695,
                  "journal_type": 1,
                  "post_id": 8889
                },
                {
                  "journal_id": 56817,
                  "journal_type": 1,
                  "post_id": 9046
                },
                {
                  "journal_id": 57059,
                  "journal_type": 3,
                  "post_id": 919
                },
                {
                  "journal_id": 57076,
                  "journal_type": 3,
                  "post_id": 929
                },
                {
                  "journal_id": 57088,
                  "journal_type": 1,
                  "post_id": 9191
                },
                {
                  "journal_id": 57717,
                  "journal_type": 3,
                  "post_id": 932
                },
                {
                  "journal_id": 58971,
                  "journal_type": 9,
                  "post_id": 9364
                },
                {
                  "journal_id": 63406,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63407,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63408,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63409,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63410,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63411,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63412,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63413,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63414,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63415,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63416,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63417,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63418,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63419,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63420,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63421,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63422,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63423,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63424,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63425,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63426,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63427,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63428,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63429,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63430,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63431,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63511,
                  "journal_type": 7,
                  "post_id": 545
                },
                {
                  "journal_id": 63525,
                  "journal_type": 7,
                  "post_id": 552
                },
                {
                  "journal_id": 63836,
                  "journal_type": 1,
                  "post_id": 9525
                },
                {
                  "journal_id": 63862,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 64320,
                  "journal_type": 7,
                  "post_id": 557
                },
                {
                  "journal_id": 65225,
                  "journal_type": 1,
                  "post_id": 9707
                },
                {
                  "journal_id": 71971,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71972,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71973,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71974,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71975,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71976,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71977,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71978,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71979,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71980,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71981,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71982,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71983,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71984,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 72873,
                  "journal_type": 3,
                  "post_id": 1135
                },
                {
                  "journal_id": 72973,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 74821,
                  "journal_type": 3,
                  "post_id": 1217
                },
                {
                  "journal_id": 80737,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 80738,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 80739,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 80740,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 80741,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 80742,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 80743,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 80744,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 80745,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 80746,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 80747,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 80748,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 80749,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 80750,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 80751,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 80752,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 80753,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 80754,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 80755,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 80756,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 80757,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 80758,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 81459,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 93487,
                  "journal_type": 3,
                  "post_id": 1328
                },
                {
                  "journal_id": 96417,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 96418,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 96419,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 96420,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 96421,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 96422,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 96423,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 96424,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 96425,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 96426,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 96427,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 96428,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 96429,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 96430,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 96431,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 96432,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 96433,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 96434,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 96435,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 96436,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 96437,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 96438,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 96605,
                  "journal_type": 7,
                  "post_id": 690
                },
                {
                  "journal_id": 97098,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 97468,
                  "journal_type": 1,
                  "post_id": 10974
                },
                {
                  "journal_id": 98271,
                  "journal_type": 3,
                  "post_id": 1363
                },
                {
                  "journal_id": 98300,
                  "journal_type": 1,
                  "post_id": 11565
                },
                {
                  "journal_id": 99085,
                  "journal_type": 1,
                  "post_id": 11756
                },
                {
                  "journal_id": 100274,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100275,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100276,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100277,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100278,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100279,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100280,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100281,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100282,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100283,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100284,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100285,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100286,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100287,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100288,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100289,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100290,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100291,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100292,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100293,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100294,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100295,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100296,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100741,
                  "journal_type": 7,
                  "post_id": 734
                },
                {
                  "journal_id": 100773,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 102098,
                  "journal_type": 1,
                  "post_id": 11903
                },
                {
                  "journal_id": 111561,
                  "journal_type": 1,
                  "post_id": 12387
                },
                {
                  "journal_id": 112760,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 112761,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 112762,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 112763,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 112764,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 112765,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 112766,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 112767,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 112768,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 112769,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 112770,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 112771,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 112772,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 112773,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 112774,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 112775,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 112776,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 112777,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 112778,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 114192,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 115500,
                  "journal_type": 1,
                  "post_id": 13159
                },
                {
                  "journal_id": 116095,
                  "journal_type": 1,
                  "post_id": 13340
                },
                {
                  "journal_id": 119994,
                  "journal_type": 7,
                  "post_id": 824
                },
                {
                  "journal_id": 120209,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 120239,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 121215,
                  "journal_type": 1,
                  "post_id": 13939
                },
                {
                  "journal_id": 141994,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 141995,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 141996,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 141997,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 141998,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 141999,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142000,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142001,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142002,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142003,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142004,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142005,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142006,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142007,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142008,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142009,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142010,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142011,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142012,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 143534,
                  "journal_type": 7,
                  "post_id": 944
                },
                {
                  "journal_id": 146955,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 147748,
                  "journal_type": 3,
                  "post_id": 1724
                },
                {
                  "journal_id": 147771,
                  "journal_type": 1,
                  "post_id": 14557
                },
                {
                  "journal_id": 150697,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 150726,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 151414,
                  "journal_type": 1,
                  "post_id": 15593
                },
                {
                  "journal_id": 151456,
                  "journal_type": 1,
                  "post_id": 15596
                },
                {
                  "journal_id": 151522,
                  "journal_type": 3,
                  "post_id": 1963
                },
                {
                  "journal_id": 155246,
                  "journal_type": 3,
                  "post_id": 1623
                },
                {
                  "journal_id": 155263,
                  "journal_type": 3,
                  "post_id": 2103
                },
                {
                  "journal_id": 155803,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 155945,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 156699,
                  "journal_type": 1,
                  "post_id": 16111
                },
                {
                  "journal_id": 157608,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 158231,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 158452,
                  "journal_type": 3,
                  "post_id": 2259
                },
                {
                  "journal_id": 158779,
                  "journal_type": 1,
                  "post_id": 16537
                },
                {
                  "journal_id": 159990,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 160181,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "f_BTC_50_ndd",
              "job_id": 9418,
              "items": [
                {
                  "journal_id": 51435,
                  "journal_type": 1,
                  "post_id": 7398
                },
                {
                  "journal_id": 51666,
                  "journal_type": 1,
                  "post_id": 7473
                },
                {
                  "journal_id": 51718,
                  "journal_type": 9,
                  "post_id": 7617
                },
                {
                  "journal_id": 53611,
                  "journal_type": 1,
                  "post_id": 7655
                },
                {
                  "journal_id": 55208,
                  "journal_type": 9,
                  "post_id": 7852
                },
                {
                  "journal_id": 55267,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 55323,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 56050,
                  "journal_type": 9,
                  "post_id": 8092
                },
                {
                  "journal_id": 56051,
                  "journal_type": 1,
                  "post_id": 8012
                },
                {
                  "journal_id": 56052,
                  "journal_type": 1,
                  "post_id": 8020
                },
                {
                  "journal_id": 56459,
                  "journal_type": 9,
                  "post_id": 8610
                },
                {
                  "journal_id": 56809,
                  "journal_type": 9,
                  "post_id": 9018
                },
                {
                  "journal_id": 60317,
                  "journal_type": 1,
                  "post_id": 9376
                },
                {
                  "journal_id": 63626,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63627,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63628,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63629,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63630,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63631,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63632,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63633,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63634,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63635,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63636,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63637,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63638,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63639,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63640,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63641,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63642,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63643,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63644,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63645,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63646,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63647,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63648,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63649,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63650,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63651,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63868,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 65030,
                  "journal_type": 1,
                  "post_id": 9758
                },
                {
                  "journal_id": 66794,
                  "journal_type": 1,
                  "post_id": 9866
                },
                {
                  "journal_id": 71715,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71716,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71717,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71718,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71719,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71720,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71721,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71722,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71723,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71724,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71725,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71726,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71727,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71728,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71729,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71730,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71731,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71732,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71733,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 71734,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 72976,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 74680,
                  "journal_type": 3,
                  "post_id": 1180
                },
                {
                  "journal_id": 75072,
                  "journal_type": 1,
                  "post_id": 10479
                },
                {
                  "journal_id": 81082,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 81083,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 81084,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 81085,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 81086,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 81087,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 81088,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 81089,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 81090,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 81091,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 81092,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 81093,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 81094,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 81095,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 81096,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 81097,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 81098,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 81099,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 81100,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 81451,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 93540,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 93541,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 93542,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 93543,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 93544,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 93545,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 93546,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 93547,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 93548,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 93549,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 93550,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 93551,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 93552,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 93553,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 93566,
                  "journal_type": 7,
                  "post_id": 683
                },
                {
                  "journal_id": 93621,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 160038,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 160168,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 165733,
                  "journal_type": 1,
                  "post_id": 18385
                },
                {
                  "journal_id": 165734,
                  "journal_type": 1,
                  "post_id": 18459
                }
              ]
            },
            {
              "DA": "LM0079",
              "job_id": 9572,
              "items": [
                {
                  "journal_id": 53600,
                  "journal_type": 9,
                  "post_id": 7787
                },
                {
                  "journal_id": 64790,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 64791,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 64792,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 64793,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 64794,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 64795,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 65310,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 74706,
                  "journal_type": 3,
                  "post_id": 1199
                },
                {
                  "journal_id": 97019,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 97076,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "LM0105",
              "job_id": 9766,
              "items": [
                {
                  "journal_id": 56249,
                  "journal_type": 9,
                  "post_id": 8262
                },
                {
                  "journal_id": 56693,
                  "journal_type": 1,
                  "post_id": 8895
                },
                {
                  "journal_id": 56814,
                  "journal_type": 1,
                  "post_id": 9042
                },
                {
                  "journal_id": 57057,
                  "journal_type": 3,
                  "post_id": 917
                },
                {
                  "journal_id": 57061,
                  "journal_type": 3,
                  "post_id": 921
                },
                {
                  "journal_id": 57085,
                  "journal_type": 1,
                  "post_id": 9190
                },
                {
                  "journal_id": 63485,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63486,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63487,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63488,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63489,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63490,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63491,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63492,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63493,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63494,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63495,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63496,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63497,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63498,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63499,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63500,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63501,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 63515,
                  "journal_type": 7,
                  "post_id": 549
                },
                {
                  "journal_id": 63872,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 64119,
                  "journal_type": 7,
                  "post_id": 555
                },
                {
                  "journal_id": 72119,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 72120,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 72121,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 72122,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 72123,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 72124,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 72125,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 72990,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 97466,
                  "journal_type": 1,
                  "post_id": 10981
                },
                {
                  "journal_id": 98270,
                  "journal_type": 3,
                  "post_id": 1362
                },
                {
                  "journal_id": 98286,
                  "journal_type": 3,
                  "post_id": 1378
                },
                {
                  "journal_id": 98299,
                  "journal_type": 1,
                  "post_id": 11568
                },
                {
                  "journal_id": 99084,
                  "journal_type": 1,
                  "post_id": 11761
                },
                {
                  "journal_id": 100474,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100475,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100476,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100477,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100478,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100479,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100480,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100481,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100482,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100483,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100484,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100485,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100486,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100487,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100488,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100489,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100490,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100491,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100492,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100493,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100494,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100495,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100496,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100497,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100498,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100499,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100744,
                  "journal_type": 7,
                  "post_id": 737
                },
                {
                  "journal_id": 100772,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 102082,
                  "journal_type": 1,
                  "post_id": 11906
                },
                {
                  "journal_id": 111560,
                  "journal_type": 1,
                  "post_id": 12382
                },
                {
                  "journal_id": 119997,
                  "journal_type": 7,
                  "post_id": 827
                }
              ]
            },
            {
              "DA": "LM00138",
              "job_id": 10864,
              "items": [
                {
                  "journal_id": 93626,
                  "journal_type": 1,
                  "post_id": 10905
                },
                {
                  "journal_id": 98453,
                  "journal_type": 1,
                  "post_id": 11713
                },
                {
                  "journal_id": 100835,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100836,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100837,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100838,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100839,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100840,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100841,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100842,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100843,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100844,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100845,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100846,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100847,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100848,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100849,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100850,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100851,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100852,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100853,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100854,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100855,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100856,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100857,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100858,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100859,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100905,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 100923,
                  "journal_type": 1,
                  "post_id": 11813
                },
                {
                  "journal_id": 111902,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111903,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111904,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111905,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111906,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111907,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111908,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111909,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111910,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111911,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111912,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111913,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111914,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111915,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111916,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111917,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111918,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111919,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111920,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111921,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111922,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111923,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 113095,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "F_BTC_162",
              "job_id": 11044,
              "items": [
                {
                  "journal_id": 98454,
                  "journal_type": 1,
                  "post_id": 11710
                },
                {
                  "journal_id": 100869,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100870,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100871,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100872,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100873,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100874,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100875,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100876,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100877,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 100906,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 100925,
                  "journal_type": 1,
                  "post_id": 11811
                },
                {
                  "journal_id": 111540,
                  "journal_type": 1,
                  "post_id": 12374
                },
                {
                  "journal_id": 111924,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111925,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111926,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111927,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111928,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111929,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111930,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111931,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111932,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111933,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111934,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111935,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111936,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111937,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111938,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111939,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111940,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111941,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111942,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111943,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111944,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 111945,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 113096,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 116080,
                  "journal_type": 1,
                  "post_id": 13235
                },
                {
                  "journal_id": 119985,
                  "journal_type": 7,
                  "post_id": 819
                },
                {
                  "journal_id": 120165,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 120251,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 140907,
                  "journal_type": 1,
                  "post_id": 14034
                },
                {
                  "journal_id": 142294,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142295,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142296,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142297,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142298,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142299,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142300,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142301,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142302,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142303,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142304,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142305,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142306,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142307,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142308,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142309,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142310,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142311,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 142312,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 146933,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 150563,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 150586,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 155773,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 155929,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 156405,
                  "journal_type": 1,
                  "post_id": 15855
                },
                {
                  "journal_id": 157706,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 158213,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 158730,
                  "journal_type": 1,
                  "post_id": 16423
                },
                {
                  "journal_id": 160035,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 160161,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 160509,
                  "journal_type": 1,
                  "post_id": 17117
                },
                {
                  "journal_id": 160510,
                  "journal_type": 1,
                  "post_id": 17120
                },
                {
                  "journal_id": 162120,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162121,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162122,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162123,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162124,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162125,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162126,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162127,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162128,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162129,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162130,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162131,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162132,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162133,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162134,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162135,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162136,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162355,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 163021,
                  "journal_type": 3,
                  "post_id": 10568
                }
              ]
            },
            {
              "DA": "F_BTC_491",
              "job_id": 13125,
              "items": [
                {
                  "journal_id": 147745,
                  "journal_type": 3,
                  "post_id": 1721
                },
                {
                  "journal_id": 147772,
                  "journal_type": 1,
                  "post_id": 14554
                },
                {
                  "journal_id": 150738,
                  "journal_type": 7,
                  "post_id": 974
                }
              ]
            },
            {
              "DA": "p_btc_37",
              "job_id": 13223,
              "items": [
                {
                  "journal_id": 155801,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 156307,
                  "journal_type": 3,
                  "post_id": 3079
                },
                {
                  "journal_id": 160520,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "P_BTC_38",
              "job_id": 13590,
              "items": [
                
              ]
            },
            {
              "DA": "P_BTC_72_NDD_MAK_BELAL",
              "job_id": 13857,
              "items": [
                
              ]
            },
            {
              "DA": "F-BTC-268-NDD-JED",
              "job_id": 13937,
              "items": [
                
              ]
            },
            {
              "DA": "F_BTC_114",
              "job_id": 13993,
              "items": [
                {
                  "journal_id": 161736,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161737,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161738,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161739,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161740,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161741,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161742,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161743,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161744,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161745,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161746,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161747,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161748,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161749,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161750,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161751,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161752,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161753,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161754,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161755,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161756,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161757,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161758,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161759,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162378,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "F_BTC_144",
              "job_id": 13995,
              "items": [
                {
                  "journal_id": 161781,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161782,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161783,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161784,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161785,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161786,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161787,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161788,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161789,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161790,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161791,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161792,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161793,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161794,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161795,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161796,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161797,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161798,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161799,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161800,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162347,
                  "journal_type": 3,
                  "post_id": 10493
                },
                {
                  "journal_id": 162371,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 162508,
                  "journal_type": 3,
                  "post_id": 10497
                },
                {
                  "journal_id": 163092,
                  "journal_type": 1,
                  "post_id": 17656
                }
              ]
            },
            {
              "DA": "F_BTC_180",
              "job_id": 13996,
              "items": [
                {
                  "journal_id": 161801,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161802,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161803,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161804,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161805,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161806,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161807,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161808,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161809,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161810,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161811,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161812,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161813,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161814,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161815,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161816,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161817,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161818,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161819,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161820,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161821,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161822,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161823,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161824,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161825,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161826,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162312,
                  "journal_type": 1,
                  "post_id": 17356
                },
                {
                  "journal_id": 162367,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "F_BTC_378",
              "job_id": 13997,
              "items": [
                {
                  "journal_id": 161827,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161828,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161829,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161830,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161831,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161832,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161833,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161834,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161835,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161836,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161837,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161838,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161839,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161840,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161841,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161842,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161843,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161844,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161845,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161846,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161847,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161848,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161849,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161850,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161851,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161852,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162368,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "F_BTC_379",
              "job_id": 13998,
              "items": [
                {
                  "journal_id": 161853,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161854,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161855,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161856,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161857,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161858,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161859,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161860,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161861,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161862,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161863,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161864,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161865,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161866,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161867,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161868,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161869,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161870,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161871,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161872,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161873,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161874,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161875,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161876,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161877,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161878,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162372,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "F_BTC_468",
              "job_id": 13999,
              "items": [
                {
                  "journal_id": 161879,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161880,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161881,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161882,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161883,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161884,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161885,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161886,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161887,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161888,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161889,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161890,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161891,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161892,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161893,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161894,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161895,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161896,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161897,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161898,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161899,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161900,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162348,
                  "journal_type": 3,
                  "post_id": 10494
                },
                {
                  "journal_id": 162366,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "F_BTC_488",
              "job_id": 14000,
              "items": [
                {
                  "journal_id": 161901,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161902,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161903,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161904,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161905,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161906,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161907,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161908,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161909,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161910,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161911,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161912,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161913,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161914,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161915,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161916,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161917,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161918,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161919,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161920,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161921,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161922,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162302,
                  "journal_type": 1,
                  "post_id": 17353
                },
                {
                  "journal_id": 162359,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "F_BTC_495",
              "job_id": 14001,
              "items": [
                {
                  "journal_id": 161923,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161924,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161925,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161926,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161927,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161928,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161929,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161930,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161931,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161932,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161933,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161934,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161935,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161936,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161937,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161938,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161939,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161940,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161941,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161942,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161943,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161944,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161945,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161946,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162379,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "F_BTC_547",
              "job_id": 14002,
              "items": [
                {
                  "journal_id": 161947,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161948,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161949,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161950,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161951,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161952,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161953,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161954,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161955,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161956,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161957,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161958,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161959,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161960,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161961,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161962,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161963,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161964,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161965,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161966,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162358,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "F_BTC_583",
              "job_id": 14003,
              "items": [
                {
                  "journal_id": 161967,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161968,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161969,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161970,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161971,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161972,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161973,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161974,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161975,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161976,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161977,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161978,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161979,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161980,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161981,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161982,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161983,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161984,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161985,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161986,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161987,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161988,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161989,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161990,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162303,
                  "journal_type": 1,
                  "post_id": 17354
                },
                {
                  "journal_id": 162360,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "F_BTC_620",
              "job_id": 14004,
              "items": [
                {
                  "journal_id": 161991,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161992,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161993,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161994,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161995,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161996,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161997,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161998,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 161999,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162000,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162001,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162002,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162003,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162004,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162005,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162006,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162361,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "F_BTC_647",
              "job_id": 14005,
              "items": [
                {
                  "journal_id": 162007,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162008,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162009,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162010,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162011,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162012,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162013,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162014,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162015,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162016,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162017,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162018,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162019,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162020,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162021,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162022,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162023,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162024,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162025,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162026,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162027,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162028,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162301,
                  "journal_type": 1,
                  "post_id": 17352
                },
                {
                  "journal_id": 162311,
                  "journal_type": 1,
                  "post_id": 17355
                },
                {
                  "journal_id": 162349,
                  "journal_type": 3,
                  "post_id": 10495
                },
                {
                  "journal_id": 162370,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 162446,
                  "journal_type": 7,
                  "post_id": 1097
                },
                {
                  "journal_id": 163118,
                  "journal_type": 1,
                  "post_id": 17658
                }
              ]
            },
            {
              "DA": "F_BTC_662",
              "job_id": 14006,
              "items": [
                {
                  "journal_id": 162029,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162030,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162031,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162032,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162033,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162034,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162035,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162036,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162503,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "F_BTC_668",
              "job_id": 14007,
              "items": [
                {
                  "journal_id": 162037,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162038,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162039,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162040,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162041,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162502,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "F_BTC_720",
              "job_id": 14008,
              "items": [
                {
                  "journal_id": 162050,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162051,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162052,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162053,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162054,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162055,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162056,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162057,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162058,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162059,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162060,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162061,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162300,
                  "journal_type": 1,
                  "post_id": 17351
                },
                {
                  "journal_id": 162346,
                  "journal_type": 3,
                  "post_id": 10492
                },
                {
                  "journal_id": 162363,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 162496,
                  "journal_type": 7,
                  "post_id": 1103
                },
                {
                  "journal_id": 162644,
                  "journal_type": 1,
                  "post_id": 17360
                }
              ]
            },
            {
              "DA": "F_BTC_727",
              "job_id": 14009,
              "items": [
                {
                  "journal_id": 162062,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162063,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162064,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162065,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162066,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162373,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "F_BTC_729",
              "job_id": 14011,
              "items": [
                {
                  "journal_id": 162070,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162071,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162072,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162073,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162374,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "F_BTC_731",
              "job_id": 14012,
              "items": [
                {
                  "journal_id": 162074,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162075,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162076,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162077,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162078,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162377,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "F_BTC_732",
              "job_id": 14013,
              "items": [
                {
                  "journal_id": 162079,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162080,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162081,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162082,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162375,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "P_BTC_223",
              "job_id": 14014,
              "items": [
                {
                  "journal_id": 162083,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162084,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162085,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162086,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162087,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162088,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162089,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162090,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162091,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162092,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162093,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162094,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162095,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162096,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162097,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162098,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162099,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162100,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162101,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162102,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162103,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162104,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162497,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "P_BTC_620",
              "job_id": 14015,
              "items": [
                {
                  "journal_id": 162110,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162111,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162112,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162313,
                  "journal_type": 1,
                  "post_id": 17357
                },
                {
                  "journal_id": 162362,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "P_BTC_718",
              "job_id": 14018,
              "items": [
                {
                  "journal_id": 162116,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162117,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162118,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162119,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162365,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "F_BTC_253",
              "job_id": 14021,
              "items": [
                
              ]
            },
            {
              "DA": "F_BTC_254",
              "job_id": 14022,
              "items": [
                
              ]
            },
            {
              "DA": "F_BTC_266",
              "job_id": 14023,
              "items": [
                
              ]
            },
            {
              "DA": "F_BTC_268",
              "job_id": 14024,
              "items": [
                
              ]
            },
            {
              "DA": "f_BTC_50",
              "job_id": 14025,
              "items": [
                {
                  "journal_id": 162234,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162235,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162236,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162237,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162238,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162239,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162240,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162241,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162242,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162243,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162244,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162245,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162246,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162247,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162248,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162249,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162250,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162251,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162252,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162253,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162254,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162255,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162256,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162257,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162258,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162259,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162490,
                  "journal_type": 2,
                  "post_id": null
                },
                {
                  "journal_id": 163022,
                  "journal_type": 7,
                  "post_id": 1105
                },
                {
                  "journal_id": 163025,
                  "journal_type": 1,
                  "post_id": 17579
                }
              ]
            },
            {
              "DA": "F_BTC_598",
              "job_id": 14029,
              "items": [
                {
                  "journal_id": 162316,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162317,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162318,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162319,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162320,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162321,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162322,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162323,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162324,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162325,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162326,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162327,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162328,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162329,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162330,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162331,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162332,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162333,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162334,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162335,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162336,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162337,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162338,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162339,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162340,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162341,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162342,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162343,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162344,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162345,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162369,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            },
            {
              "DA": "F_BTC_7321",
              "job_id": 14031,
              "items": [
                {
                  "journal_id": 162455,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162456,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162457,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162458,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162459,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162460,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162461,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162462,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162463,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162464,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162465,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162466,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162467,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162468,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162469,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162470,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162471,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162472,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162473,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162474,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162475,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162476,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162477,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162478,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162479,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162480,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162481,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162482,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162483,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162484,
                  "journal_type": 6,
                  "post_id": null
                },
                {
                  "journal_id": 162500,
                  "journal_type": 2,
                  "post_id": null
                }
              ]
            }
          ]';
        $no_data ;
        $payload = json_decode($payload, true);
        foreach($payload as $recored){
             $items = $recored['items'];
               
            if(count($items)>0){
                foreach($items as $per_recored){ 
                     
                    if($per_recored['journal_type'] == 6 || $per_recored['journal_type'] == 2){
                        $dayload = Journal::find($per_recored['journal_id']);
                        $dayload->driverId = $recored['job_id']; 
                        $dayload->save();
                        // transfer to priv da save changes
                    } 
                    if($per_recored['journal_type'] == 1 || $per_recored['journal_type'] == 9){
                        $loans = Loan::find($per_recored['post_id']); 
                        $loans->driverId = $recored['job_id'];
                        // dd($recored['job_id']);
                        $loans->save();
                        
                    }
                    if($per_recored['journal_type'] == 3){
                        $crediteNote = CreditNotes::where('id',$per_recored['post_id'])->get(); 
                        if(count($crediteNote)>0){
                            $crediteNote[0]->driverId = $recored['job_id'];
                            $crediteNote[0]->save();
                        } 
                    }
                    if($per_recored['journal_type'] == 4){
                        dd('4');
                    }
                    if($per_recored['journal_type'] == 5){
                        dd('5');
                    }
                    if($per_recored['journal_type'] == 7){
                        $settelment = Settlements::where('id',$per_recored['post_id'])->get();
                        if(count($settelment)>0){
                            $settelment[0]->driverId= $recored['job_id'];
                            $settelment[0]->save();
                        }
                    }
                    if($per_recored['journal_type'] == 8){
                        dd('8');
                    }  
                }
            }else{
                $no_data[] = $recored;  
            }
        }
        dd($no_data);
         
        
    }


    public function apiLandmark(){  
      $sql = "SELECT id,job_id FROM `drivers` WHERE id in ( 9060 ,
      9572 ,
      13857 ,
      13868 ,
      13223 ,
      13590 ,
      10864 ,
      11044 ,
      14021 ,
      14022 ,
      14023 ,
      14024 ,
      14025 ,
      13937 ,
      9418 ,
      9766 ,
      13125 ,
      13993 ,
      13995 ,
      13996 ,
      13997 ,
      13998 ,
      13999 ,
      14000 ,
      14001 ,
      14002 ,
      14003 ,
      14004 ,
      14005 ,
      14006 ,
      14007 ,
      14008 ,
      14009 ,
      14011 ,
      14012 ,
      14013 ,
      14014 ,
      14015 ,
      14018 ,
      14029 ,
      14031 ,
      9402)";

      $payload = DB::select($sql);
      $returenedValue;
     // Begin
     foreach($payload as $ittems){
        $ids = [];
        $dayload = Journal::where('driverId',$ittems->id)->get();   
        foreach($dayload as $dayload_iteem){
            
            // switch ($dayload_iteem->journal_type_id) {
            //     case '1':
            //         # code... 
            //         $loans =DB::select("select * from loans where driverId =".$dayload_iteem->driverId." "); 
            //         foreach($loans as $loans_item){
            //             // $loans_item->save();
            //         }
            //         break;
            //     case '2':
            //         # code...
            //         break;
            //     case 3:
            //         # code...
            //         break;
            //     case 4:
            //         # code...
            //         break;
            //     case 5:
            //         # code...
            //         break;
            //     case 6:
            //         # code...
                    
            //         break;
            //     default:
            //         # code...
            //         break;
            // } 
            $ids[] = [
                "journal_id"=>$dayload_iteem->id,
                "journal_type"=>$dayload_iteem->journal_type_id,
                "post_id"=>$dayload_iteem->post_id
            ];
        }
        //  dd($ids); 
         $returenedValue[] = [
            "DA"=>$ittems->job_id,
            "job_id"=>$ittems->id,
            "items"=>$ids,
        ]; 
     }
        return response()->json($returenedValue,200); 
     
        // $crediteNote = CreditNotes::where('driverId',$from)->get(); 
        // foreach($crediteNote as $crediteNote_item){
        //     $crediteNote_item->driverId = $to;
        //     $crediteNote_item->note = $crediteNote_item->note." مٌرحلة من حساب (".$or_from.")";
        //     // $crediteNote_item->save();
        // } 

        // $packages_report = Packages_report::where('driverId',$from)->get();
        // foreach($packages_report as $packages_report_item){
        //     $packages_report_item->driverId = $to;
        //     // $packages_report_item->save();
        // }
     



    // end Begin



        dd($payload);
    }
    public function CheckingLandmarkCorrectDAs(){
        $driver = Drivers::where('warehouseId',289)->get();
        // dd($driver);
        $Payload ;
        $faild_Payload ;
        foreach($driver as $item){
            // dd($item);
            $mystring = $item->fullName;
            $findme   = 'NDD_';
            $pos = strpos($mystring, $findme);
            if($pos != false){
                $new_job_id = '';
                $pos = $pos+2;
                for ($i=0; $i <=$pos ; $i++) { 
                    # code...
                    $new_job_id = $new_job_id.$mystring[$i]; 
                }
                $Payload[] = [
                    0=>$item->job_id,
                    1=>$new_job_id
                ];
            }else{
                $findme   = 'ndd';
                $pos = strpos($mystring, $findme);
                if($pos != false){
                    $new_job_id = '';
                    $pos = $pos+2;
                    for ($i=0; $i <=$pos ; $i++) {
                        # code...
                        $new_job_id = $new_job_id.$mystring[$i]; 
                    }
                    $Payload[] = [
                        0=>$item->job_id,
                        1=>strtoupper($new_job_id)
                    ]; 
                }else{ 
                    $findme   = 'NDD';
                    $pos = strpos($item->job_id, $findme);
                    // if( $item->job_id=='F_BTC_253_NDD'){
                    //     dd($item->job_id);
                    // }
                    if($pos != false){
                        $findme = '_JED';
                        $pos = strpos($item->job_id, $findme);

                        if($pos !=false){
                            $pos = $pos-1;
                            $new_job_id='';
                            for ($i=0; $i <=$pos ; $i++) {                                 
                                $new_job_id = $new_job_id.$item->job_id[$i]; 
                            }
                            $Payload[] = [
                                0=>$item->job_id,
                                1=>strtoupper($item->job_id)
                            ];
                        }else{
                            $pos=$pos+2;
                            $new_job_id='';
                            for ($i=0; $i <=$pos ; $i++) {                           
                                $new_job_id = $new_job_id.$item->job_id[$i]; 
                            }
                            $Payload[] = [
                                0=>$item->job_id,
                                1=>strtoupper($item->job_id)
                            ];
                        }
                        // dd($new_job_id); 
                        // dd($item->job_id); 
                    }else{
                        $faild_Payload[] = "Fails to find ".$item->fullName.' - '.$item->job_id;
                        // dd("Fails to find ".$item->fullName.' - '.$item->job_id);
                    }
                    
                }
                // dd("False to find string ".$item->fullName.' '.$item->job_id);
            }
            
        }
        foreach($Payload as $iteeems){
            $findme   = '_JED';
            $pos = strpos($item->job_id, $findme);
            
            if($pos != false){
                dd($pos);
            }
        }
        return view('dummy',compact('Payload'));
        dd($Payload);
        dd("CheckingLandmarkCorrectDAs");
    }
    public function CheckingLandmarkDAs(){
        
        $or_from = 'D2105745301';
        $or_to = 'D2105745301';
        $from = $or_from;
        $to = $or_to;
        $from = DB::select("select id,job_id from drivers where job_id='".$from."'");
        $from = $from[0]->id;
        $to = DB::select("select id,job_id from drivers where job_id='".$to."'");
        $to = $to[0]->id; 
        // Balance
        $settelment = Settlements::where('driverId',$from)->get();
        foreach($settelment as $settelment_item){
            $settelment_item->driverId = $to;
            $settelment_item->note = $settelment_item->note." مٌرحلة من حساب (".$or_from.")";
            dd($settelment_item->note);
            $settelment_item->save();
        }
        $crediteNote = CreditNotes::where('driverId',$from)->get(); 
        foreach($crediteNote as $crediteNote_item){
            $crediteNote_item->driverId = $to;
            $crediteNote_item->note = $crediteNote_item->note." مٌرحلة من حساب (".$or_from.")";
            $crediteNote_item->save();
        }
        $loans = Loan::where('driverId',$from)->get();  
        foreach($loans as $loans_item){
            $loans_item->driverId = $to;
            $loans_item->note = $loans_item->note." مٌرحلة من حساب (".$or_from.")";
            $loans_item->save();
        }
        $dayload = Journal::where('driverId',$from)->get(); 
        foreach($dayload as $dayload_item){
            $dayload_item->driverId = $to;
            $dayload_item->save();
        }
        $packages_report = packages_report::where('driverId',$from)->get();
        foreach($packages_report as $packages_report_item){
            $packages_report_item->driverId = $to;
            $packages_report_item->save();
        }
        //End Blance
        try {
            $driver = DB::select("DELETE from drivers where id=".$from."");
        } catch (\Throwable $th) {
            //throw $th;
            dd("CAN NOT DELETE DA: ".$from);
        }
        dd("Done");
    }
    //
    public function propertiesConfirm($token){
        dd($token);
        // sleep(2);
        // dd(Auth::user());
        // $sql = "UPDATE `properties_assignment` SET `delivery_timestamp`=NOW()  WHERE `reference_no`='".$token."'";
        $payload = DB::update("UPDATE `properties_assignment` SET `delivery_timestamp`=NOW() WHERE `reference_no`='".$token."'");
        //  dd($payload);
        // send a confirmation email to created by or/and HR 
        return "propertiesConfirm";
    }
    function CompanyProprtiesIssuanceForm($user_id){ 
        
        // $filename = 'hello_world.pdf';
        $sql = "SELECT users.name as 'user_name',users.department,users.IdentityNo,btc_properties.*,lkp_properties_category.name_ar as 'category_name_ar',lkp_properties_status.status_ar,`properties_assignment`.reference_no,`properties_assignment`.delivery_timestamp FROM `properties_assignment` JOIN users ON users.id = properties_assignment.user_id JOIN btc_properties ON btc_properties.id = properties_assignment.property_id JOIN lkp_properties_category ON lkp_properties_category.id = btc_properties.property_id JOIN lkp_properties_status ON lkp_properties_status.id = btc_properties.status_id WHERE properties_assignment.reference_no = '".$user_id."';"; //2
        $payload = DB::select($sql);
        // dd($payload[0]->category_name_ar); 
        $table ;
        foreach($payload as $getuniq){
            // dd($getuniq->category_name_ar);
            $uniq_array[] = $getuniq->name.' ('.$getuniq->category_name_ar.') - '.$getuniq->description ;
        }
        $uniq_arrayssss = array_unique($uniq_array);
        $uniq_array = array_count_values($uniq_array); 
        foreach($uniq_arrayssss as $item){
            $table[] = [
                "description"=>$item,
                "status"=>$getuniq->status_ar,
                "qty"=>$uniq_array[$item]
            ]; 
        }
        // dd($payload);
        return view('CompanyProprtiesIssuanceForm',compact('payload','table'));
        return response()->download(public_path($filename));

        // return view('CompanyProprtiesIssuanceForm'); 
    }
    function index(){
        $json_data = '
        [
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2482,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8230,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8235,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2471,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2446,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2484,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2478,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8248,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8255,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2479,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2474,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8243,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 3192,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "فان بضاعه",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8271,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2483,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8245,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8267,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8229,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8261,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8246,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },  
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8268,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2450,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2435,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8262,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8274,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8244,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2448,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8225,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2473,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8266,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8242,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2486,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8238,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8247,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8257,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ك",
                    "number": 4876,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "فان بضاعه",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8253,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2477,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ص",
                    "number": 1913,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "اورفان",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2489,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8232,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ص",
                    "number": 1905,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "اورفان",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8258,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8256,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8273,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8228,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2488,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2481,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2475,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8234,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2480,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8249,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8240,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2472,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8270,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8239,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8259,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8227,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8263,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8241,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8251,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8264,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2449,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8254,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8233,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 2487,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "رينو",
                    "model": "فان",
                    "year": 2021
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8236,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ص",
                    "text3": "ب",
                    "number": 8237,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "بكس 404",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجزيرة لتأجير السيارات",
                    "en": "J R C"
                },
                "ownerIdNumber": 7001364939,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4966,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4973,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4984,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4981,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4969,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4968,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4970,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4982,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4967,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4971,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4978,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4983,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4965,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4974,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4975,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "س",
                    "text3": "ن",
                    "number": 4976,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "بيجو",
                    "model": "فان",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الجبر لتأجير السيارات",
                    "en": "Al - Jabbar Rent A Car Company"
                },
                "ownerIdNumber": 7007537371,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6497,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ر",
                    "number": 7455,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5437,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8320,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ر",
                    "number": 7457,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6510,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5438,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6538,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5432,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6459,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5448,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5156,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5078,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5443,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ط",
                    "text3": "ط",
                    "number": 8469,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "اورفان",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6509,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6511,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8323,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6492,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6534,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6493,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5430,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6430,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ن",
                    "number": 4357,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6569,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5079,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6491,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6517,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8302,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6574,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5434,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6431,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ن",
                    "number": 4551,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ر",
                    "number": 7453,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6530,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8310,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            }, 
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6536,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5450,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ط",
                    "text3": "ط",
                    "number": 8472,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "اورفان",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6540,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5433,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6513,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6489,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ر",
                    "number": 7499,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6462,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6516,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6496,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ن",
                    "number": 4591,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ط",
                    "text3": "ط",
                    "number": 8467,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "اورفان",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8308,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ر",
                    "number": 7454,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8321,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ر",
                    "number": 7452,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8301,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6546,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6514,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5158,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ط",
                    "text3": "ط",
                    "number": 8470,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "اورفان",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6531,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8322,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6533,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6461,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ن",
                    "number": 4356,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8306,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5153,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6535,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },        {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ر",
                    "number": 7500,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5440,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6532,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ر",
                    "number": 7460,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6460,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6487,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6572,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6220,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6515,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6495,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8307,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6570,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6490,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5439,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ط",
                    "text3": "ط",
                    "number": 8471,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "اورفان",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5441,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6512,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5442,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6543,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ر",
                    "number": 7458,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            }
            ,
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5447,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6573,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8305,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ر",
                    "number": 7472,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6571,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ط",
                    "text3": "ط",
                    "number": 8466,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "اورفان",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5152,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ب",
                    "text2": "ط",
                    "text3": "ط",
                    "number": 8468,
                    "type": {
                        "code": 3,
                        "nameAr": "نقل خاص",
                        "nameEn": "Private Transport"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "اورفان",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8309,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6537,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ر",
                    "number": 7456,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ن",
                    "number": 4355,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5431,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8304,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5157,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6432,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5154,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5446,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ر",
                    "number": 7498,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5436,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8311,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5449,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6539,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "ط",
                    "number": 8303,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "س",
                    "text3": "ي",
                    "number": 8000,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "لاندروفر",
                    "model": "رانج روفر",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ح",
                    "text3": "م",
                    "number": 6494,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "نيسان",
                    "model": "صني",
                    "year": 2022
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            },
            {
                "plate": {
                    "text1": "ر",
                    "text2": "ص",
                    "text3": "ن",
                    "number": 5435,
                    "type": {
                        "code": 1,
                        "nameAr": "خاص",
                        "nameEn": "Private Car"
                    }
                },
                "branchName": null,
                "makerAndModel": {
                    "maker": "كيا",
                    "model": "بيجاس",
                    "year": 2023
                },
                "ownerName": {
                    "ar": "شركة الراجحي المصرفية للأستثمار",
                    "en": "ALRAJHI BANK"
                },
                "ownerIdNumber": 7000102744,
                "actualDriverId": 7016327863
            }
        
        
        ]'; 
        
        $jsonArray = json_decode($json_data, true);
        $html = "<table style='text-align: center;'>
            <tr>
                <th>#</th>
                <th>الوحة </th>
                <th>الشركة المصنعة </th>
                <th>الموديل </th>
                <th>تاريخ الصنع </th>
                <th>  اسم المالك </th>
                <th>رقم الهيكل </th>
                <th>الرقم التسلسلي </th>
                <th>اللون   </th>
            </tr> ";
        foreach($jsonArray as $k=>$item){
            $html = $html . "<tr>";
             
            $makerAndModel= $item['makerAndModel'];
            // dd($makerAndModel['maker']);
            $plate = $item;
            $ownerName = $plate['ownerName'];
            // dd($ownerName['ar']);
            $plate2 = $plate['plate']; 
            $vehicles_plate = $plate2['text1'].' '.$plate2['text2'].' '.$plate2['text3'].' '.$plate2['number'];
            // dd($vehicles_plate);
            $html = $html . "<td>".++$k."</td>
                            <td>".$vehicles_plate."</td>
                            <td>".$makerAndModel['maker']."</td>
                            <td>".$makerAndModel['model']."</td>
                            <td>".$makerAndModel['year']."</td>
                            <td>".$ownerName['ar']."</td>
            ";
            $select = "select * from vehicles where plate like '%".$vehicles_plate."%'";
            $select = DB::select($select);
            // dd($select); 
            if(count($select)>0){
                // dd($select[0]->body_number);
                $html = $html . "<td>".$select[0]->body_number."</td>
                                    <td>".$select[0]->SNno."</td>
                                    <td>".$select[0]->color."</td>";
            }else{
                $html = $html . "<td>لم يتم العثور على المركبة       </td>
                <td>لم يتم العثور على المركبة   </td>
                <td>لم يتم العثور على المركبة       </td>";
            } 
            $html = $html . "</tr>";
        }
         echo $html. "</table>";
         exit;
         // true for associative arrays, false for objects
        // var_dump($jsonArray);
        
        $vehicle = array("vehicles_plate"=>$vehicles_plate,"vehicle_man_year"=>$makerAndModel['maker'],"model"=>$makerAndModel['model']);
        // $makerAndModel = $plate ;

        dd($vehicle);
        dd($plate2['text1'].' '.$plate2['text2'].' '.$plate2['text3'].' '.$plate2['number']); 
    }

}
