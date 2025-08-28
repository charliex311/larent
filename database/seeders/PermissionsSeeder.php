<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'dashboard'],
            ['name' => 'service'],
            ['name' => 'service-add'],
            ['name' => 'service-edit'],
            ['name' => 'service-delete'],
            ['name' => 'users'],
            ['name' => 'users-add'],
            ['name' => 'users-edit'],
            ['name' => 'users-delete'],
            ['name' => 'users-unpaid-user'],
            ['name' => 'users-manage-permissions'],
            ['name' => 'job-jobs-calender'],
            ['name' => 'job-add'],
            ['name' => 'job-edit'],
            ['name' => 'job-drag-drop'],
            ['name' => 'job-delete'],
            ['name' => 'journal'],
            ['name' => 'journal-add'],
            ['name' => 'journal-delete'],
            ['name' => 'journal-edit'],
            ['name' => 'work-work-hour'],
            ['name' => 'work-column-customer-name'], 
            ['name' => 'work-column-service-name'],
            ['name' => 'work-column-employee-name'],
            ['name' => 'work-column-message'],
            ['name' => 'work-column-files'],
            ['name' => 'work-column-date'],
            ['name' => 'work-column-start-time'],
            ['name' => 'work-column-stop-time'],
            ['name' => 'work-column-service-price'],
            ['name' => 'work-column-employee-hours'],
            ['name' => 'work-column-employee-price'],
            ['name' => 'work-column-customer-hours'],
            ['name' => 'work-column-customer-price'],
            ['name' => 'work-column-total-price'],
            ['name' => 'work-column-status'],
            ['name' => 'work-edit-message'],
            ['name' => 'work-edit-start-time'],
            ['name' => 'work-edit-stop-time'],
            ['name' => 'work-edit-employee-hours'],
            ['name' => 'work-edit-customer-hours'],
            ['name' => 'invoices'],
            ['name' => 'invoices-paid'],
            ['name' => 'invoices-unpaid'],
            ['name' => 'invoices-add'],
            ['name' => 'invoices-edit'],
            ['name' => 'invoices-delete'],
            ['name' => 'invoices-invoice-sent_to_email'],
            ['name' => 'invoices-make-payment'],
            ['name' => 'withdraw'],
            ['name' => 'withdraw-paid'],
            ['name' => 'withdraw-unpaid'],
            ['name' => 'deposit-deposit-history'],
            ['name' => 'billing-billing-history'],
            ['name' => 'payment-payment-method'],
            ['name' => 'payment-add'],
            ['name' => 'payment-edit'],
            ['name' => 'payment-delete'],
            ['name' => 'chat'],
            ['name' => 'chat-only-admin'],
            ['name' => 'logs'],
            ['name' => 'pop_ups'],
            ['name' => 'pop_ups-add'],
            ['name' => 'pop_ups-edit'],
            ['name' => 'pop_ups-delete'],
            ['name' => 'pop_ups-visible'],
            ['name' => 'settings-view'],
            ['name' => 'settings-update'],
            ['name' => 'settings-upload-documents'],
            ['name' => 'email-templates'],
            ['name' => 'email-add'],
            ['name' => 'email-edit'],
            ['name' => 'email-delete'],
            ['name' => 'servers-smtp-server'],
            ['name' => 'optional-optinal-products'],
            ['name' => 'optional-add'],
            ['name' => 'optional-edit'],
            ['name' => 'optional-delete'],
        ];
        foreach ($permissions as $permission) {
            Permission::create([
                'name'  => $permission['name']
            ]);
        }
    }
}
