<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AutologinController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

Route::get('queue-work', function () {
    if (Session::get('queue_restart', true)) {
        \Illuminate\Support\Facades\Artisan::call('queue:restart');
        Session::forget('queue_restart');
    }
    Illuminate\Support\Facades\Artisan::call('queue:work', ['--stop-when-empty' => true]);
})->name('queue.work');

Route::get('active-joblist-checker', function () {
    Illuminate\Support\Facades\Artisan::call('app:active-joblist-checker');
})->name('queue.active-joblist-checker');





Route::get('/', AdminLogin::class)->name('admin-login')->middleware('guest');

Route::get('/ms', function () {
    Artisan::call('optimize:clear');
    Artisan::call('cache:forget spatie.permission.cache');
    if (File::exists(public_path().'/storage')) {
        File::deleteDirectory(public_path().'/storage');
    }
    Artisan::call('storage:link');
    session()->flash('success','System Optimized.');
    return redirect('/admin/dashboard');
})->name('make-storage');


Route::fallback(function() {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    } else {
        return redirect()->route('admin-login');
    }
});


Route::group(['prefix'=>'admin','middleware'=>'auth'], function(){
    Route::get('/dashboard', DashboardPage::class)->name('dashboard')->middleware('can:dashboard');
    
    Route::get('/logout-from-admin', function(Illuminate\Http\Request $request) {
        if ($request->session()->has('impersonator_id')) {
            $impersonatorId = $request->session()->pull('impersonator_id');
            $impersonatorType = $request->session()->pull('impersonator_type');
            session()->forget('birthday_modal_shown');
            Auth::loginUsingId($impersonatorId);
            return redirect('admin/users?type='.$impersonatorType);
        } else {
            Auth::logout();
            session()->flash('success','Welcome Back !! Explore Beyond');
            return redirect()->route('admin-login');
        }
    })->name('admin-logout');
    


    Route::get('/add-service', AddServicePage::class)->name('add-services')->middleware('can:service-add');
    Route::get('/edit-service', AddServicePage::class)->name('edit-services')->middleware('can:service-edit');

    Route::get('/services', AllServicePage::class)->name('services')->middleware('can:service');

    Route::get('/active-service', ActiveServicePage::class)->name('active-services')->middleware('can:service');
    Route::get('/inactive-service', InactiveServicePage::class)->name('inactive-services')->middleware('can:service');
    Route::get('/pending-service', PendingServicePage::class)->name('pending-services')->middleware('can:service');

    Route::get('/users', UsersPage::class)->name('users')->middleware('can:users');
    Route::get('/unpaid-users', UnpaidUsersPage::class)->name('unpaid-users')->middleware('can:users-unpaid-user');
    Route::get('/add-user', AddUserPage::class)->name('add-user')->middleware('can:users-add');
    Route::get('/edit-secondary-info', UserSecondaryInfoPage::class)->name('edit-secondary')->middleware('can:users-add');
    Route::get('/add-address', AddAddressPage::class)->name('add-addresses')->middleware('can:users-add');
    Route::get('/add-social-links', AddSocialLinkPage::class)->name('add-social-links')->middleware('can:users-add');
    Route::get('/add-documents', AddDocumentPage::class)->name('add-documents')->middleware('can:users-add');
    Route::get('/email-permissions', EmailPermissions::class)->name('email-permissions')->middleware('can:users-add');
    Route::get('/permissions', ManagePermissionPage::class)->name('permissions')->middleware('can:users-manage-permissions');
    Route::get('/add-contact-person', AddContactPage::class)->name('add-contact-person')->middleware('can:users-add');
    Route::get('/add-new-services', AddNewServices::class)->name('add-new-services')->middleware('can:users-add');
    Route::get('/jobs-calendar', JobCalendar::class)->name('jobs-calendar')->middleware('can:job-jobs-calender');
    Route::get('/add-job', AddJob::class)->name('add-job')->middleware('can:job-add');
    Route::get('/add-single-job', AddSingleJob::class)->name('add-single-job')->middleware('can:job-add');
    Route::get('/works-hour', WorkHour::class)->name('works-hour')->middleware('can:work-work-hour');
    Route::get('/billing-history', BillingHistory::class)->name('billing-history')->middleware('can:billing-billing-history');
    Route::get('/view/works-hour', ViewWorkHour::class)->name('view-works-hour')->middleware('can:work-work-hour');

    Route::get('/journal-page', JournalPage::class)->name('journal-page');
    Route::get('/journals', UserJournalPage::class)->name('user-journal-page');

    
    /* INVOICES */
    Route::get('/invoices', InvoicePage::class)->name('invoices')->middleware('can:invoices');
    Route::get('/paid-invoices', PaidInvoices::class)->name('paid-invoices')->middleware('can:invoices-paid');
    Route::get('/unpaid-invoices', UnpaidInvoices::class)->name('unpaid-invoices')->middleware('can:invoices-unpaid');
    Route::get('/add-new-invoice', GenerateInvoice::class)->name('add-invoice')->middleware('can:invoices-add');
    Route::get('/edit-new-invoice', GenerateInvoice::class)->name('edit-invoice')->middleware('can:invoices-edit');
    Route::get('/view-invoice', ViewInvoice::class)->name('view-invoice')->middleware('can:invoices');
    Route::get('/invoice-payments', InvoicePayment::class)->name('invoice-payments')->middleware('can:invoices-make-payment');
    
    Route::get('/customer-pdf-download', [DashboardController::class, 'downloadPDF'])->name('download-customer-invoice');
    Route::get('/chats', ChatPage::class)->name('chat')->middleware('can:chat');
    Route::get('/logs', LogPage::class)->name('logs')->middleware('can:logs');
    Route::get('/settings', SettingPage::class)->name('settings')->middleware('can:settings-view');
    Route::get('/payment-method', PaymentMethodPage::class)->name('payment-method')->middleware('can:payment-payment-method');
    Route::match(['get', 'post'], '/upload-img-for-payment-method', [DashboardController::class, 'upload_img_for_email_payment_method'])->name('upload-img-for-payment-method');
    Route::get('/document-page', DocumentPage::class)->name('document-page')->middleware('can:settings-upload-documents');
    Route::get('/deposit-history', AdminDepositPage::class)->name('all-deposits-history')->middleware('can:deposit-deposit-history');
    Route::get('/document-view-page', DocumentViewPage::class)->name('document-view-page')->middleware('can:settings-upload-documents');
    Route::get('/email-templates', EmailTemplate::class)->name('email-templates')->middleware('can:email-templates');
    Route::get('/add-template', AddTemplate::class)->name('add-template')->middleware('can:email-add');
    Route::get('/optional-products', OptionalProductPage::class)->name('optional-product')->middleware('can:optional-optinal-products');
    Route::get('/add-optional-product', AddOptionalProduct::class)->name('add-optional-product')->middleware('can:optional-add');
    Route::get('/edit-optional-product', AddOptionalProduct::class)->name('edit-optional-product')->middleware('can:optional-edit');
    Route::get('/smtp-server', AddSmtpServer::class)->name('smtp-server')->middleware('can:servers-smtp-server');


    Route::get('/withdraw-paid', WithdrawPaid::class)->name('withdraw-paid')->middleware('can:withdraw-paid');
    Route::get('/withdraw-unpaid', WithdrawUnpaid::class)->name('withdraw-unpaid')->middleware('can:withdraw-unpaid');

    Route::get('/poplist', PopList::class)->name('pop-list')->middleware('can:pop_ups');


    // Auto Login
    Route::get('/impersonate/{userId}', [AutologinController::class, 'impersonate'])->name('impersonate');

});