<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\UtilityHelpers;

use Mail;

use App\AccountsModel;
use App\NewsModel;

class WeeklyNewsMailer extends Command
{
    use UtilityHelpers;
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
        $accounts = AccountsModel::all();
        $news = NewsModel::whereBetween('created_at', [date('Y-m-d H:i:s', strtotime('-6 days')), date('Y-m-d H:i:s')])->get();
        $weekly_news = [];

        if(count($news) > 0) {
            foreach($news as $news_item) {
                $news_url = url('/news/' . date('Y', strtotime($news_item->created_at)) . '/' . date('m', strtotime($news_item->created_at)) . '/' . date('d', strtotime($news_item->created_at)) . '/' . str_replace(' ', '_', $news_item->headline));

                $weekly_news[] = [
                    'headline' => $news_item->headline,
                    'username' => $news_item->username,
                    'url' => $news_url,
                    'elapsedCreatedAt' => $news_item->elapsedCreatedAt()
                ];
            }

            foreach($accounts as $account) {
                if(strlen($account->userInfo->middle_name) > 1) {
                    $full_name = $account->userInfo->first_name . ' ' . substr($account->userInfo->middle_name, 0, 1) . '. ' . $account->userInfo->last_name;
                } else {
                    $full_name = $account->userInfo->first_name . ' ' . $account->userInfo->last_name;
                }

                if($account->userInfo->mobile_number !== null) {
                    $this->send($account->userInfo->mobile_number, 'F.A.D.P. Weekly News Alert. Go check out your email and see all the news posted this week.');
                }

                Mail::send('emails.weekly_news', [
                    'first_name' => $account->userInfo->first_name,
                    'news' => $weekly_news
                ], function($message) use ($account, $full_name) {
                    $message->to($account->email_address, $full_name)->subject('F.A.D.P. Weekly News Alert');
                });
            }
        }
    }
}
