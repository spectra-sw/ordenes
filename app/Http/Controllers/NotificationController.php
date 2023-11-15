<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // create a new notification
    public function create(Request $request)
    {
        $notification = new Notification();
        $notification->content = $request->content;
        $notification->empleado_id = $request->empleado_id;
        $notification->save();
        return response()->json([
            'message' => 'notification created',
            'notification' => $notification
        ], 201);
    }

    // get all notifications by authenticated user
    public function findAll()
    {
        $user_id = session()->get('user');
        $new_notifications = Notification::where('empleado_id', $user_id)->where('read', false)->get();
        $old_notifications = Notification::where('empleado_id', $user_id)->where('read', true)->limit(10)->get();

        return response()->json([
            'new_notifications' => $new_notifications,
            'old_notifications' => $old_notifications,
        ], 200);
    }

    public function read(Request $request)
    {
        Notification::whereIn('id', $request->notification_ids)->update(['read' => true]);
        return response()->json([
            'message' => 'notifications read',
        ], 200);
    }

    public function test()
    {
        $cc_list = [
            ["cc" => '6408225', "telefono" => '3176991218'],
            ["cc" => '79761330', "telefono" => '3057361027'],
            ["cc" => '73195429', "telefono" => '3192733777'],
            ["cc" => '1233497147', "telefono" => '3058131914'],
            ["cc" => '1000464745', "telefono" => '3118220521'],
            ["cc" => '14471106', "telefono" => '3145464594'],
            ["cc" => '1130661788', "telefono" => '3164952166'],
            ["cc" => '1113677485', "telefono" => '3186893967'],
            ["cc" => '71225248', "telefono" => '3008178359'],
            ["cc" => '1144191478', "telefono" => '3173277101'],
            ["cc" => '17635191', "telefono" => '3135336830'],
            ["cc" => '16285736', "telefono" => '3122397377'],
            ["cc" => '17641703', "telefono" => '3167905699'],
            ["cc" => '80172982', "telefono" => '3043367137'],
            ["cc" => '16929395', "telefono" => '3122695308'],
            ["cc" => '16935870', "telefono" => '3175160803'],
            ["cc" => '38471571', "telefono" => '3170750632'],
            ["cc" => '1121838166', "telefono" => '3504451981'],
            ["cc" => '1144194955', "telefono" => '3178947842'],
            ["cc" => '1111784436', "telefono" => '316 3554059'],
            ["cc" => '1130641697', "telefono" => '3145097620'],
            ["cc" => '16917937', "telefono" => '3168668247'],
            ["cc" => '1113661389', "telefono" => '3117590540'],
            ["cc" => '98431790', "telefono" => '3175766019'],
            ["cc" => '1130679584', "telefono" => '3103888345'],
            ["cc" => '94492508', "telefono" => '3153771398'],
            ["cc" => '1094948756', "telefono" => '3128599014'],
            ["cc" => '1107527400', "telefono" => '3212417381'],
            ["cc" => '1006246910', "telefono" => '3184229174'],
            ["cc" => '1020450015', "telefono" => '3004781905'],
            ["cc" => '1114732236', "telefono" => '3186813974'],
            ["cc" => '1006072573', "telefono" => '3106539541'],
            ["cc" => '1144039134', "telefono" => '3156687861'],
            ["cc" => '76292605', "telefono" => '3146203055'],
            ["cc" => '1129519259', "telefono" => '3006332828'],
            ["cc" => '1094931294', "telefono" => '3102220219'],
            ["cc" => '1088589375', "telefono" => '3147900836'],
            ["cc" => '16946597', "telefono" => '3152076754'],
            ["cc" => '80220773', "telefono" => '3174220630'],
            ["cc" => '1143983090', "telefono" => '3117253598'],
            ["cc" => '1107063861', "telefono" => '3022884669'],
            ["cc" => '16376409', "telefono" => '3013708191'],
            ["cc" => '79855082', "telefono" => '3213556607'],
            ["cc" => '1130615602', "telefono" => '3188390631'],
            ["cc" => '9873567', "telefono" => '3163619890'],
            ["cc" => '1111774980', "telefono" => '3175917857'],
            ["cc" => '1032463364', "telefono" => '3208316129'],
            ["cc" => '1022996035', "telefono" => '3184707664'],
            ["cc" => '1005936154', "telefono" => '3147286735'],
            ["cc" => '1144038174', "telefono" => '3058138944'],
            ["cc" => '1006054782', "telefono" => '3205129112'],
            ["cc" => '6105551', "telefono" => '3173312510'],
            ["cc" => '16946072', "telefono" => '3167722245'],
            ["cc" => '80657037', "telefono" => '3202892056'],
            ["cc" => '80657772', "telefono" => '3114738596'],
            ["cc" => '1148444137', "telefono" => '3173608691'],
            ["cc" => '1110364290', "telefono" => '3135947773'],
            ["cc" => '1094921347', "telefono" => '3167056741'],
            ["cc" => '1127583431', "telefono" => '3158920683'],
            ["cc" => '80807877', "telefono" => '3219144363'],
            ["cc" => '1144089820', "telefono" => '3157028151'],
            ["cc" => '13930239', "telefono" => '3133741502'],
            ["cc" => '1053835892', "telefono" => '3216419844'],
            ["cc" => '1111809069', "telefono" => '3235230807'],
            ["cc" => '1144157566', "telefono" => '3006667885'],
            ["cc" => '1113537522', "telefono" => '3184248086'],
            ["cc" => '1039681232', "telefono" => '3135558384'],
            ["cc" => '1130594458', "telefono" => '3177916927'],
            ["cc" => '1130643825', "telefono" => '3104981742'],
            ["cc" => '1130626452', "telefono" => '3116807417'],
            ["cc" => '1144190403', "telefono" => '3206762736'],
            ["cc" => '1130623825', "telefono" => '3187510653'],
            ["cc" => '1143832246', "telefono" => '3173058527'],
            ["cc" => '1130632830', "telefono" => '3103883888'],
            ["cc" => '1022407744', "telefono" => '3222818809'],
            ["cc" => '1079915127', "telefono" => '3003229480'],
            ["cc" => '1023831891', "telefono" => '3135239209'],
            ["cc" => '1111788657', "telefono" => '3122507464'],
            ["cc" => '1111542256', "telefono" => '3124386356'],
            ["cc" => '1112483207', "telefono" => '3172853649'],
            ["cc" => '1143993150', "telefono" => '3014580962'],
            ["cc" => '1005869440', "telefono" => '3226923305'],
            ["cc" => '1085309278', "telefono" => '3128548977'],
            ["cc" => '1014222477', "telefono" => '3118960506'],
            ["cc" => '1130635933', "telefono" => '3164921438'],
            ["cc" => '1114729565', "telefono" => '3158710862'],
            ["cc" => '1112766588', "telefono" => '3117410819'],
            ["cc" => '1118817953', "telefono" => '3013868894'],
            ["cc" => '1116433419', "telefono" => '3154380877'],
            ["cc" => '94441222', "telefono" => '3116459788'],
            ["cc" => '1062306394', "telefono" => '3178541548'],
            ["cc" => '1037627252', "telefono" => '3116656802'],
            ["cc" => '1151955297', "telefono" => '3208007590'],
            ["cc" => '80145181', "telefono" => '3209803422'],
            ["cc" => '1116266864', "telefono" => '3183082686'],
            ["cc" => '1004072338', "telefono" => '3207043470'],
            ["cc" => '14676462', "telefono" => '3154667763'],
            ["cc" => '94443280', "telefono" => '3116551824'],
            ["cc" => '16073211', "telefono" => '3045624308'],
            ["cc" => '14477546', "telefono" => '3172137822'],
            ["cc" => '1151959790', "telefono" => '3152158842'],
            ["cc" => '1053840424', "telefono" => '3137729289'],
            ["cc" => '1144087635', "telefono" => '3142175240'],
            ["cc" => '80098246', "telefono" => '3058708283'],
            ["cc" => '94418750', "telefono" => '3217007972'],
            ["cc" => '14471095', "telefono" => '3165257667'],
            ["cc" => '91532163', "telefono" => '3046719879'],
            ["cc" => '1130672473', "telefono" => '3206172459'],
            ["cc" => '17676008', "telefono" => '3127624831'],
            ["cc" => '1144183900', "telefono" => '3165229759'],
            ["cc" => '1111768066', "telefono" => '3116937465'],
            ["cc" => '1049798250', "telefono" => '3112459064'],
            ["cc" => '1144158924', "telefono" => '3158511332'],
            ["cc" => '1022423231', "telefono" => '3213637611'],
            ["cc" => '4758855', "telefono" => '3042401400'],
            ["cc" => '1111813404', "telefono" => '3147787902'],
            ["cc" => '80015457', "telefono" => '3214002371'],
            ["cc" => '1014204913', "telefono" => '3228449516'],
            ["cc" => '72276042', "telefono" => '3226040958'],
            ["cc" => '1113306444', "telefono" => '3002814121'],
            ["cc" => '1143985416', "telefono" => '3136692943'],
            ["cc" => '16936043', "telefono" => '3174040662'],
            ["cc" => '1111787837', "telefono" => '3205315052'],
            ["cc" => '1143865635', "telefono" => '3003340343'],
            ["cc" => '72342879', "telefono" => '3508146344'],
            ["cc" => '94446055', "telefono" => '3148932916'],
            ["cc" => '1143878223', "telefono" => '3186826580'],
            ["cc" => '1111776975', "telefono" => '3183369887'],
            ["cc" => '1101686056', "telefono" => '3133596916'],
            ["cc" => '1006071305', "telefono" => '3195230717'],
            ["cc" => '8163939', "telefono" => '3187662793'],
            ["cc" => '1018461330', "telefono" => '3218206903'],
            ["cc" => '1026585430', "telefono" => '3194496846'],
            ["cc" => '16506434', "telefono" => '3136291986'],
            ["cc" => '1144177743', "telefono" => '3156564431'],
            ["cc" => '79857208', "telefono" => '3123077444'],
            ["cc" => '1005976935', "telefono" => '3126159378'],
            ["cc" => '94456406', "telefono" => '3136556602'],
        ];

        foreach ($cc_list as $key => $value) {
            $e = Empleado::where('cc', $value['cc']);
            $e->telefono = $value['telefono'];
            $e->saved();
        }

        // array:10 [
        //     128 => "1101686056"
        //     129 => "1006071305"
        //     130 => "8163939"
        //     131 => "1018461330"
        //     132 => "1026585430"
        //     133 => "16506434"
        //     134 => "1144177743"
        //     135 => "79857208"
        //     136 => "1005976935"
        //     137 => "94456406"
        // ]
    }
}
