<?php

namespace Database\Seeders;

use App\Enums\ApprovalAction;
use App\Enums\LeaveRequestStatus;
use App\Models\ApprovalLog;
use App\Models\Department;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database with Arabic sample data.
     */
    public function run(): void
    {
        // 1. الأقسام (Departments)
        $hrDept = Department::create([
            'name' => 'الموارد البشرية',
            'description' => 'إدارة شؤون الموظفين والتوظيف والعلاقات العمالية.',
        ]);

        $engineeringDept = Department::create([
            'name' => 'تكنولوجيا المعلومات',
            'description' => 'تطوير البرمجيات والصيانة والبنية التحتية والتقنية.',
        ]);

        $marketingDept = Department::create([
            'name' => 'التسويق والإعلام',
            'description' => 'إدارة العلامة التجارية والحملات الإعلانية والتواصل.',
        ]);

        $financeDept = Department::create([
            'name' => 'المالية والمحاسبة',
            'description' => 'الميزانيات والمدفوعات والتقارير المالية.',
        ]);

        // 2. الموظفون (Users)
        $admin = User::factory()->create([
            'name' => 'مدير النظام (أحمد محمود)',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'department_id' => $hrDept->id,
            'manager_id' => null,
        ]);

        $techManager = User::factory()->create([
            'name' => 'سارة أحمد (مديرة التقنية)',
            'email' => 'sarah@example.com',
            'password' => Hash::make('password'),
            'department_id' => $engineeringDept->id,
            'manager_id' => $admin->id,
        ]);

        $devUser1 = User::factory()->create([
            'name' => 'محمد علي (مطور برمجيات)',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'department_id' => $engineeringDept->id,
            'manager_id' => $techManager->id,
        ]);

        $devUser2 = User::factory()->create([
            'name' => 'فاطمة الزهراء (مصممة واجهات)',
            'email' => 'alice@example.com',
            'password' => Hash::make('password'),
            'department_id' => $engineeringDept->id,
            'manager_id' => $techManager->id,
        ]);

        $marketingUser = User::factory()->create([
            'name' => 'خالد عمر (أخصائي تسويق)',
            'email' => 'mark@example.com',
            'password' => Hash::make('password'),
            'department_id' => $marketingDept->id,
            'manager_id' => $admin->id,
        ]);

        // 3. أنواع الإجازات (Leave Types)
        $annualLeave = LeaveType::create([
            'name' => 'إجازة سنوية',
            'color' => '#3B82F6',
            'max_days_per_year' => 21,
            'requires_attachment' => false,
            'is_active' => true,
        ]);

        $sickLeave = LeaveType::create([
            'name' => 'إجازة مرضية',
            'color' => '#EF4444',
            'max_days_per_year' => 10,
            'requires_attachment' => true,
            'is_active' => true,
        ]);

        $unpaidLeave = LeaveType::create([
            'name' => 'إجازة بدون أجر',
            'color' => '#6B7280',
            'max_days_per_year' => 30,
            'requires_attachment' => false,
            'is_active' => true,
        ]);

        $emergencyLeave = LeaveType::create([
            'name' => 'إجازة طارئة',
            'color' => '#F59E0B',
            'max_days_per_year' => 5,
            'requires_attachment' => false,
            'is_active' => true,
        ]);

        $allUsers = [$admin, $techManager, $devUser1, $devUser2, $marketingUser];
        $leaveTypes = [$annualLeave, $sickLeave, $unpaidLeave, $emergencyLeave];

        // 4. أرصدة الإجازات للسنة الحالية (Leave Balances)
        $currentYear = (int) date('Y');
        foreach ($allUsers as $user) {
            foreach ($leaveTypes as $type) {
                LeaveBalance::create([
                    'user_id' => $user->id,
                    'leave_type_id' => $type->id,
                    'year' => $currentYear,
                    'entitled_days' => $type->max_days_per_year,
                    'used_days' => 0,
                    'adjustment_days' => 0,
                ]);
            }
        }

        // 5. عينة من طلبات الإجازات (Leave Requests & Logs)

        // طلب قيد الانتظار
        LeaveRequest::create([
            'user_id' => $devUser1->id,
            'leave_type_id' => $annualLeave->id,
            'start_date' => now()->addDays(10)->format('Y-m-d'),
            'end_date' => now()->addDays(14)->format('Y-m-d'),
            'days_count' => 5,
            'reason' => 'إجازة عائلية سنوية لقضاء العطلة.',
            'status' => LeaveRequestStatus::Pending,
        ]);

        // طلب مقبول
        $approvedRequest = LeaveRequest::create([
            'user_id' => $devUser1->id,
            'leave_type_id' => $annualLeave->id,
            'start_date' => now()->subDays(20)->format('Y-m-d'),
            'end_date' => now()->subDays(18)->format('Y-m-d'),
            'days_count' => 3,
            'reason' => 'راحة شخصية ومتابعة بعض المعاملات.',
            'status' => LeaveRequestStatus::Approved,
            'decided_by' => $techManager->id,
            'decided_at' => now()->subDays(21),
        ]);

        // تحديث الرصيد للطلب المقبول
        LeaveBalance::where('user_id', $devUser1->id)
            ->where('leave_type_id', $annualLeave->id)
            ->where('year', $currentYear)
            ->increment('used_days', 3);

        ApprovalLog::create([
            'leave_request_id' => $approvedRequest->id,
            'user_id' => $techManager->id,
            'action' => ApprovalAction::Approved,
            'comment' => 'تمت الموافقة. إجازة سعيدة!',
        ]);

        // طلب مرفوض
        $rejectedRequest = LeaveRequest::create([
            'user_id' => $devUser2->id,
            'leave_type_id' => $annualLeave->id,
            'start_date' => now()->addDays(2)->format('Y-m-d'),
            'end_date' => now()->addDays(6)->format('Y-m-d'),
            'days_count' => 5,
            'reason' => 'سفر طارئ.',
            'status' => LeaveRequestStatus::Rejected,
            'decided_by' => $techManager->id,
            'decided_at' => now()->subDays(1),
            'rejection_reason' => 'تعذر القبول بسبب وجود إطلاق مشروع هام في نفس الفترة.',
        ]);

        ApprovalLog::create([
            'leave_request_id' => $rejectedRequest->id,
            'user_id' => $techManager->id,
            'action' => ApprovalAction::Rejected,
            'comment' => 'تعذر القبول بسبب وجود إطلاق مشروع هام في نفس الفترة.',
        ]);

        // طلب إجازة مرضية
        LeaveRequest::create([
            'user_id' => $marketingUser->id,
            'leave_type_id' => $sickLeave->id,
            'start_date' => now()->subDays(1)->format('Y-m-d'),
            'end_date' => now()->addDays(1)->format('Y-m-d'),
            'days_count' => 3,
            'reason' => 'وعكة صحية وإصابة بالإنفلونزا.',
            'status' => LeaveRequestStatus::Pending,
        ]);
    }
}
