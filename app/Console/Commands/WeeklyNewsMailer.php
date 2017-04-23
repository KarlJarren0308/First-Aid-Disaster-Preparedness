<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Mail;

use App\AccountsModel;
use App\NewsModel;

class WeeklyNewsMailer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:weekly-news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends weekly news e-mail';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // $accounts = AccountsModel::all();
        // $news = NewsModel::whereBetween('created_at', [date('Y-m-d', strtotime('-6 days')), date('Y-m-d')])->get();
        //
        // foreach($accounts as $account) {
        //     if(strlen($account->userInfo->middle_name) > 1) {
        //         $full_name = $account->userInfo->first_name . ' ' . substr($account->userInfo->middle_name, 0, 1) . '. ' . $account->userInfo->last_name;
        //     } else {
        //         $full_name = $account->userInfo->first_name . ' ' . $account->userInfo->last_name;
        //     }
        //
        //     Mail::queue('emails.weekly_news', [
        //         'first_name' => 'Karl Jarren',
        //         'news' => $news
        //     ], function($message) use ($account, $full_name) {
        //         $message->to($account->email_address, $full_name)->subject('F.A.D.P. Weekly News Alert');
        //     });
        // }

        $news = NewsModel::whereBetween('created_at', [date('Y-m-d', strtotime('-6 days')), date('Y-m-d')])->get();

        Mail::send('emails.weekly_news', [
            'first_name' => 'Karl Jarren',
            'news' => $news
        ], function($message) {
            $message->to('karljarren0308@gmail.com', 'Karl T. Macadangdang')->subject('F.A.D.P. Weekly News Alert');
        });
    }
}
