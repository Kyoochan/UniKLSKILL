<?php

use App\Http\Controllers\ActivityCommentController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityProposalController;
use App\Http\Controllers\AnnouncementCommentController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\ClubJoinRequestController;
use App\Http\Controllers\ClubProposalController;
use App\Http\Controllers\ClubReportController;
use App\Http\Controllers\ClubSocialController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\MeritProposalController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProposalTemplateController;
use App\Http\Controllers\SkillProposalController;
use App\Http\Controllers\TranscriptController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/register', [AuthController::class, 'userRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'storeRegister'])->name('register.perform');

Route::get('/login', [AuthController::class, 'userLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'storeLogin'])->name('login.perform');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout.perform')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| Protected Pages (Requires Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Staff account management
    Route::get('/staffaccount', [AuthController::class, 'showStaffAccount'])->name('staffaccount');
    Route::post('/staffaccount/store', [AuthController::class, 'storeStaffAccount'])->name('staffaccount.store');
    Route::put('/advisor/{id}/assign', [AuthController::class, 'assignAdvisor'])->name('advisor.assign');
    Route::put('/advisor/{id}/unassign', [AuthController::class, 'unassignAdvisor'])->name('advisor.unassign');

    // Club Proposal Form (Student)
    Route::get('/club/propose', [ClubProposalController::class, 'create'])->name('club.propose');
    Route::post('/club/propose', [ClubProposalController::class, 'store'])->name('club.propose.store');

    // Manage Club Proposals (Admin)
    Route::get('/club/request', [ClubProposalController::class, 'index'])->name('club.request');
    Route::post('/club/request/{id}/approve', [ClubProposalController::class, 'approve'])->name('club.request.approve');
    Route::post('/club/request/{id}/reject', [ClubProposalController::class, 'reject'])->name('club.request.reject');
    Route::delete('/club/request/{id}/delete', [ClubProposalController::class, 'destroy'])->name('club.request.delete');
    Route::get('/club/request/{id}/notify', [ClubProposalController::class, 'notifyReason'])->name('club.request.notify');

    // Club Management (Admin/Advisor/High Com)
    Route::get('/club/create/{proposal_id?}', [ClubController::class, 'create'])->name('club.create');
    Route::post('/club/store', [ClubController::class, 'store'])->name('club.store');
    Route::get('/club/{id}/edit', [ClubController::class, 'edit'])->name('club.edit');
    Route::put('/club/{id}', [ClubController::class, 'update'])->name('club.update');
    Route::delete('/club/{id}', [ClubController::class, 'destroy'])->name('club.destroy');

    // Upload / Update Proposal Template (Admin)
    Route::post('/club/request', [ProposalTemplateController::class, 'store'])->name('club.request.store');

    // Club Activity Proposal  (High Com)
    Route::get('/club/{id}/propose-activity', [ActivityProposalController::class, 'show'])->name('proposeactivity.show');
    Route::post('/club/{id}/propose-activity', [ActivityProposalController::class, 'store'])->name('proposeactivity.store');
    Route::delete('/club/{club_id}/proposal/{proposal_id}', [ActivityProposalController::class, 'destroy'])->name('proposeactivity.destroy');
    Route::get('/post-activity/{proposal_id}', [ActivityProposalController::class, 'showPostActivity'])->name('postactivity.show');
    Route::delete('/club/{club_id}/posted-activity/{posted_activity_id}', [ActivityProposalController::class, 'destroyPostedActivity'])->name('postedactivity.destroy');

    // Club Activity Management (Advisor)
    Route::get('/club/{id}/manage-activity', [ActivityProposalController::class, 'manage'])->name('manageactivity.show');
    Route::post('/post-activity/{proposal_id}', [ActivityProposalController::class, 'storePostedActivity'])->name('postactivity.store');
    Route::post('/club/{club_id}/proposal/{proposal_id}/approve', [ActivityProposalController::class, 'approve'])->name('manageactivity.approve');
    Route::post('/club/{club_id}/proposal/{proposal_id}/reject', [ActivityProposalController::class, 'reject'])->name('manageactivity.reject');

    Route::get('/proposal/view/{id}', [ActivityProposalController::class, 'viewProposed'])->name('postactivity.view');

    // Club Announcement (Advisor/High Com)
    Route::get('/club/{club_id}/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/club/{club_id}/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::delete('/club/{club_id}/announcements/{announcement_id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

    // viewing posted announcement/activity (all active members of Club)
    Route::get('/activity/{id}', [ActivityController::class, 'show'])->name('activity.show');
    Route::get('/club/announcement/{announcement_id}', [AnnouncementController::class, 'show'])->name('announcement.show');

    // comment section/discussion
    Route::post('/activities/{activity}/comments', [ActivityCommentController::class, 'store'])->name('activity.comment.store');
    Route::delete('/activity/comment/{id}', [ActivityCommentController::class, 'destroy'])->name('activity.comment.destroy');

    Route::post('/announcements/{announcement}/comment', [AnnouncementCommentController::class, 'store'])->name('announcement.comment.store');
    Route::delete('/announcement/comment/{id}', [AnnouncementCommentController::class, 'destroy'])->name('announcement.comment.destroy');

    // Club Report Submission (High Com)
    Route::get('/club/report/{report}', [ClubReportController::class, 'viewReport'])->name('report.view');
    Route::get('/club/{club}/submitreport', [ClubReportController::class, 'showForm'])->name('submitreport.show');
    Route::post('/club/{club}/submitreport', [ClubReportController::class, 'store'])->name('submitreport.store');
    Route::post('/club/report/{report}/remarks', [ClubReportController::class, 'addRemarks'])->name('report.addRemarks');

    // Advisor view all submitted club reports
    Route::get('/advisor/reports', [ClubReportController::class, 'index'])->name('viewreport.show');

    // Add / view remark
    Route::get('/report/{report}/remark', [ClubReportController::class, 'remarkForm'])->name('report.remark');
    Route::post('/report/{report}/remark', [ClubReportController::class, 'storeRemark'])->name('report.remark.store');

    // View all reports for a specific club
    Route::get('/club/{club}/reports', [ClubReportController::class, 'viewReport'])->name('report.viewreport');

    // Club Social Media Management (High Com/Advisor)
    Route::get('/club/{clubId}/socials', [ClubSocialController::class, 'index'])->name('club.socials');
    Route::post('/club/{clubId}/socials', [ClubSocialController::class, 'store'])->name('club.socials.store');
    Route::delete('/club/{clubId}/socials/{social}', [ClubSocialController::class, 'destroy'])->name('club.socials.destroy');

    // News Management (Admin)

    Route::get('/news/manage', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news/store', [NewsController::class, 'store'])->name('news.store');
    Route::delete('/news/{id}/delete', [NewsController::class, 'destroy'])->name('news.destroy');
    Route::get('/admin/proposalnews/manage', [NewsController::class, 'manage'])->name('proposalnews.manage');
    Route::patch('/proposalnews/{id}/approve', [NewsController::class, 'approve'])->name('proposalnews.approve');
    Route::patch('/proposalnews/{id}/reject', [NewsController::class, 'reject'])->name('proposalnews.reject');

    // Proposal News (Student)
    Route::get('/proposalnews/create', [NewsController::class, 'proposalCreate'])->name('proposalnews.create');
    Route::post('/proposalnews/store', [NewsController::class, 'proposalStore'])->name('proposalnews.store');
    Route::get('/proposalnews', [NewsController::class, 'proposalIndex'])->name('proposalnews.index');
    Route::get('/proposalnews/{id}', [NewsController::class, 'proposalShow'])->name('proposalnews.show');

    // Merit Proposal Routes (GHOCS)
    Route::get('/merit-proposal/create', [MeritProposalController::class, 'create'])->name('merit.create');
    Route::post('/merit-proposal/store', [MeritProposalController::class, 'store'])->name('merit.store');

    Route::get('/skill-proposals', [SkillProposalController::class, 'index'])->name('skill_proposals.index');
    Route::get('/skill-proposals/create', [SkillProposalController::class, 'create'])->name('skill_proposals.create');
    Route::post('/skill-proposals', [SkillProposalController::class, 'store'])->name('skill_proposals.store');

    // Secretary views all pending (GHOCS and Skill Management)
    Route::get('/secretary/merit/manage', [MeritProposalController::class, 'pending'])->name('merit.manage');
    Route::get('/merit/pending', [MeritProposalController::class, 'pending'])->name('merit.pending');
    Route::post('/merit/{id}/approve', [MeritProposalController::class, 'approve'])->name('merit.approve');
    Route::get('/merit/{id}/reject', [MeritProposalController::class, 'rejectForm'])->name('merit.reject.form');
    Route::post('/merit/{id}/reject', [MeritProposalController::class, 'reject'])->name('merit.reject');
    Route::get('/merit/{id}', [MeritProposalController::class, 'show'])->name('merit.view');

    // Secretary Skill Management
    Route::get('/secretary/skill-proposals', [SkillProposalController::class, 'secretaryIndex'])->name('secretary.skill_proposals');
    Route::post('/secretary/skill-proposals/{id}/approve', [SkillProposalController::class, 'approve'])->name('skill_proposals.approve');
    Route::post('/secretary/skill-proposals/{id}/reject', [SkillProposalController::class, 'reject'])->name('skill_proposals.reject');

    // transcript route
    Route::get('/transcript/{id}', [TranscriptController::class, 'show'])->name('transcript.show');

});

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('homePage.show'));
Route::get('/home', [PageController::class, 'displayHome'])->name('homePage.show');

Route::get('/news', [PageController::class, 'displayNews'])->name('newsPage.show');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

Route::get('/curriculum', [PageController::class, 'displayCurriculum'])->name('curriculumPage.show');
Route::get('/faq', [PageController::class, 'displayFaq'])->name('faqPage.show');
Route::get('/club', [ClubController::class, 'index'])->name('club.index');
Route::get('/proposal-template/download', [ProposalTemplateController::class, 'download'])->name('proposal.template.download');
Route::get('/club/{id}', [ClubController::class, 'show'])->name('club.show');

Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
Route::post('/faqs/ask', [FaqController::class, 'ask'])->name('faqs.ask');

// Chatbot ROute
Route::post('/faq/ask', [FaqController::class, 'ask'])->name('faq.ask');

/*
|--------------------------------------------------------------------------
| Notification Routes
|--------------------------------------------------------------------------
*/

Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index')->middleware('auth');
Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read')->middleware('auth');
Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy')->middleware('auth');
Route::delete('/notifications', [NotificationController::class, 'destroyAll'])->name('notifications.destroyAll')->middleware('auth');
Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsReadAjax'])
    ->name('notifications.markAllReadAjax')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| Club Membership Routes
|--------------------------------------------------------------------------
*/
Route::get('/club/{id}/members', [ClubController::class, 'showMembers'])->name('club.showmember')->middleware('auth');
Route::post('/club/{id}/join', [ClubJoinRequestController::class, 'store'])->name('club.join')->middleware('auth');

// Manage Club Member
Route::delete('/club/{club}/member/{user}', [ClubController::class, 'removeMember'])->name('club.member.remove')->middleware('auth');
Route::post('/club/{club}/join-request/{request}/approve', [ClubJoinRequestController::class, 'approve'])->name('club.joinrequest.approve')->middleware('auth');
Route::post('/club/{club}/join-request/{request}/reject', [ClubJoinRequestController::class, 'reject'])->name('club.joinrequest.reject')->middleware('auth');

Route::post('/club/{club}/join-requests/approve-all', [ClubJoinRequestController::class, 'approveAllJoinRequests'])->name('club.joinrequest.approveAll')->middleware('auth');
Route::post('/club/{club}/join-requests/reject-all', [ClubJoinRequestController::class, 'rejectAllJoinRequests'])->name('club.joinrequest.rejectAll')->middleware('auth');
Route::post('/club/{club}/member/{user}/toggle-committee', [ClubController::class, 'toggleCommittee'])->name('club.member.toggleCommittee');
Route::post('/club/{club}/member/{user}/set-role', [ClubController::class, 'setRole'])->name('club.member.setRole')->middleware('auth');
