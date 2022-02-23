<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class M_AD_News extends Model
{
    public $table = 'm_ad_news';
    use HasFactory;
    /*
    * Create:zayar(2022/01/15)
    * Update:
    * This function is used to show news add view.
    */

    public function newsAddView()
    {
        Log::channel('adminlog')->info("M_AD_News Model", [
            'Start newsAddView'
        ]);
        Log::channel('adminlog')->info("M_AD_News Model", [
            'End newsAddView'
        ]);
        return M_News_Category::where('del_flg', '=', 0)->get();
    }
    /*
   * Create:zayar(2022/01/15)
   * Update:
   * This function is used to store news.
   */

    public function newsAdd($request, $siteLogo)
    {
        Log::channel('adminlog')->info("M_AD_News Model", [
            'Start newsAdd'
        ]);
        $admin = new M_AD_News();
        $admin->title = $request->input('title');
        $admin->source = $siteLogo;
        $admin->detail = $request->input('detail');
        $admin->category = $request->input('category');
        $admin->write_by = 1; //need to change
        $admin->save();
        Log::channel('adminlog')->info("M_AD_News Model", [
            'End newsAdd'
        ]);
    }
    /*
   * Create:zayar(2022/01/15)
   * Update:
   * This function is used to show news edit view.
   */

    public function newsEditView($newsid)
    {
        Log::channel('adminlog')->info("M_AD_News Model", [
            'Start newsEditView'
        ]);
        Log::channel('adminlog')->info("M_AD_News Model", [
            'End newsEditView'
        ]);
        return  M_AD_News::select('*', DB::raw('m_ad_news.id AS newsid'))
            ->where('m_ad_news.id', $newsid)
            ->where('m_ad_news.del_flg', 0)
            ->join('m_news_category', 'm_news_category.id', '=', 'm_ad_news.category')
            ->first();
    }

    /*
   * Create:zayar(2022/01/15)
   * Update:
   * This function is used to update news.
   */

    public function newsEdit($request, $id)
    {
        Log::channel('adminlog')->info("M_AD_News Model", [
            'Start newsEdit'
        ]);
        $admin = M_AD_News::find($id);
        $admin->title = $request->input('title');
        $admin->detail = $request->input('detail');
        $admin->category = $request->input('category');
        $admin->write_by = 1; //need to change
        $admin->save();
        Log::channel('adminlog')->info("M_AD_News Model", [
            'End newsEdit'
        ]);
    }
    /*
   * Create:zayar(2022/01/15)
   * Update:
   * This function is used to update del_flg to 1.
   */
    public function newsDelete($id)
    {
        Log::channel('adminlog')->info("M_AD_News Model", [
            'Start newsDelete'
        ]);
        $admin = M_AD_News::find($id);
        $admin->del_flg = 1;
        $admin->save();
        Log::channel('adminlog')->info("M_AD_News Model", [
            'End newsDelete'
        ]);
    }

    use HasFactory;

    /*
     * Create : Min Khant(13/1/2022)
     * Update :
     * Explain of function : To show important news for users
     * Prarameter : no
     * return : news
     * */
    public function news()
    {
        Log::channel('customerlog')->info('M_AD_News Model', [
            'start news'
        ]);
        $news = M_AD_News::where('del_flg', '=', '0')
            ->where('public', '0')
            ->get();
        Log::channel('customerlog')->info('M_AD_News Model', [
            'end news'
        ]);
        return $news;
    }

    /*
     * Create : zayar(24/1/2022)
     * Update :
     * Explain of function : To show  news for users in inform alert box
     * Prarameter : no
     * return : news
     * */
    public function newsLimited()
    {
        Log::channel('adminlog')->info("M_AD_News Model", [
            'Start newsLimited'
        ]);
        Log::channel('adminlog')->info("M_AD_News Model", [
            'End newsLimited'
        ]);
        $allnews =
            M_AD_News::orderBy('updated_at', 'DESC')
            ->select('*', DB::raw('updated_at AS newscreated'))
            ->where('m_ad_news.del_flg', 0)

            // ->leftjoin('m_news_category', 'm_news_category.id', '=', 'm_ad_news.category')

            ->limit(3)
            ->get();
        return $allnews;
    }

    /*
     * Create : zayar(25/1/2022)
     * Update :
     * Explain of function : To show  news for users in news page
     * Prarameter : no
     * return : news
     * */
    public function newsAll()
    {
        Log::channel('adminlog')->info("M_AD_News Model", [
            'Start newsLimited'
        ]);
        Log::channel('adminlog')->info("M_AD_News Model", [
            'End newsLimited'
        ]);
        return M_AD_News::select('*', DB::raw('m_ad_news.updated_at AS newscreated'))
            ->orderBy('m_ad_news.updated_at', 'DESC')
            ->where('m_ad_news.del_flg', 0)
            ->join('m_news_category', 'm_news_category.id', '=', 'm_ad_news.category')
            ->paginate(10);
    }
    /*
     * Create : zayar(15/2/2022)
     * Update :
     * Explain of function : To show  news for users in news page
     * Prarameter : no
     * return : news
     * */
    public function newsAllToCount()
    {


        Log::channel('adminlog')->info("M_AD_News Model", [
            'Start newsAllToCount'
        ]);

        Log::channel('adminlog')->info("M_AD_News Model", [
            'End newsAllToCount'
        ]);
        $news = M_AD_News::where('del_flg', 0)
            // ->whereDate('created_at',  Carbon::now()->subDays(3))
            ->whereBetween('updated_at', [
                \carbon\Carbon::now()->subdays(2)->format('Y-m-d'),
                \carbon\Carbon::now()->addDays(1)->format('Y-m-d')
            ])->get();

        Log::channel('adminlog')->info("count", [
            $news
        ]);
        return $news;
    }
}
