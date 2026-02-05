<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\AssetMeter;
use App\Models\Company;
use App\Models\Document;
use App\Models\Inspection;
use App\Models\InspectionItem;
use App\Models\MaintenanceSchedule;
use App\Models\Part;
use App\Models\User;
use App\Models\Vendor;
use App\Models\WorkOrder;
use App\Models\WorkOrderLabor;
use App\Models\WorkOrderPart;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // === COMPANY ===
        $company = Company::create([
            'name' => 'Apex Fleet Services',
            'slug' => 'apex-fleet',
            'address' => '4200 Industrial Blvd, Houston, TX 77032',
            'phone' => '(713) 555-0100',
        ]);

        // === USERS ===
        $sarah = User::create([
            'name' => 'Sarah Chen',
            'email' => 'sarah@apexfleet.com',
            'password' => Hash::make('Apex!Admin2026#'),
        ]);
        $sarah->companies()->attach($company);
        $sarah->assignRole('admin');

        $mike = User::create([
            'name' => 'Mike Rodriguez',
            'email' => 'mike@apexfleet.com',
            'password' => Hash::make('Apex!Mgr2026#'),
        ]);
        $mike->companies()->attach($company);
        $mike->assignRole('manager');

        $jake = User::create([
            'name' => 'Jake Thompson',
            'email' => 'jake@apexfleet.com',
            'password' => Hash::make('Apex!Tech2026#'),
        ]);
        $jake->companies()->attach($company);
        $jake->assignRole('technician');

        $emily = User::create([
            'name' => 'Emily Davis',
            'email' => 'emily@apexfleet.com',
            'password' => Hash::make('Apex!Drive2026#'),
        ]);
        $emily->companies()->attach($company);
        $emily->assignRole('driver');

        // === VENDORS ===
        $vendors = [];
        $vendorData = [
            ['name' => 'Houston Fleet Repair', 'contact_name' => 'Carlos Mendez', 'email' => 'carlos@houstonfleetrepair.com', 'phone' => '(713) 555-0201', 'address' => '8800 Airline Dr, Houston, TX 77037'],
            ['name' => 'Lone Star Tire Center', 'contact_name' => 'Bobby Watson', 'email' => 'bobby@lonestartire.com', 'phone' => '(713) 555-0302', 'address' => '12500 Gulf Fwy, Houston, TX 77034'],
            ['name' => 'Gulf Coast Parts Supply', 'contact_name' => 'Maria Santos', 'email' => 'maria@gulfcoastparts.com', 'phone' => '(713) 555-0403', 'address' => '6100 Westpark Dr, Houston, TX 77057'],
            ['name' => 'Texas Equipment Dealers', 'contact_name' => 'Jim Crawford', 'email' => 'jim@texasequip.com', 'phone' => '(281) 555-0504', 'address' => '15200 Hempstead Rd, Houston, TX 77040'],
        ];
        foreach ($vendorData as $v) {
            $vendors[] = Vendor::create(array_merge($v, ['company_id' => $company->id]));
        }

        // === PARTS ===
        $parts = [];
        $partsData = [
            ['name' => 'Oil Filter', 'part_number' => 'FL-820S', 'category' => 'Filters', 'quantity_on_hand' => 24, 'minimum_quantity' => 10, 'unit_cost' => 8.99, 'location' => 'Shelf A-1'],
            ['name' => 'Air Filter', 'part_number' => 'CA-11114', 'category' => 'Filters', 'quantity_on_hand' => 12, 'minimum_quantity' => 6, 'unit_cost' => 18.49, 'location' => 'Shelf A-2'],
            ['name' => 'Brake Pads (Front)', 'part_number' => 'BP-1707', 'category' => 'Brakes', 'quantity_on_hand' => 4, 'minimum_quantity' => 8, 'unit_cost' => 45.99, 'location' => 'Shelf B-1'],
            ['name' => 'Brake Pads (Rear)', 'part_number' => 'BP-1708', 'category' => 'Brakes', 'quantity_on_hand' => 6, 'minimum_quantity' => 8, 'unit_cost' => 42.99, 'location' => 'Shelf B-1'],
            ['name' => 'Wiper Blades (22")', 'part_number' => 'WB-22', 'category' => 'Electrical', 'quantity_on_hand' => 16, 'minimum_quantity' => 10, 'unit_cost' => 12.99, 'location' => 'Shelf C-1'],
            ['name' => 'Synthetic Oil 5W-30 (qt)', 'part_number' => 'MO-5W30', 'category' => 'Fluids', 'quantity_on_hand' => 48, 'minimum_quantity' => 24, 'unit_cost' => 7.49, 'location' => 'Shelf D-1'],
            ['name' => 'Transmission Fluid (qt)', 'part_number' => 'TF-DXIII', 'category' => 'Fluids', 'quantity_on_hand' => 18, 'minimum_quantity' => 12, 'unit_cost' => 9.99, 'location' => 'Shelf D-2'],
            ['name' => 'Coolant 50/50 (gal)', 'part_number' => 'CL-5050', 'category' => 'Fluids', 'quantity_on_hand' => 8, 'minimum_quantity' => 6, 'unit_cost' => 14.99, 'location' => 'Shelf D-3'],
            ['name' => 'Battery - Group 65', 'part_number' => 'BAT-65', 'category' => 'Electrical', 'quantity_on_hand' => 3, 'minimum_quantity' => 4, 'unit_cost' => 149.99, 'location' => 'Floor E-1'],
            ['name' => 'Headlight Bulb H11', 'part_number' => 'HL-H11', 'category' => 'Electrical', 'quantity_on_hand' => 10, 'minimum_quantity' => 6, 'unit_cost' => 22.99, 'location' => 'Shelf C-2'],
            ['name' => 'Serpentine Belt', 'part_number' => 'SB-K060923', 'category' => 'Engine', 'quantity_on_hand' => 5, 'minimum_quantity' => 3, 'unit_cost' => 28.99, 'location' => 'Shelf A-3'],
            ['name' => 'Spark Plugs (set of 6)', 'part_number' => 'SP-9619', 'category' => 'Engine', 'quantity_on_hand' => 4, 'minimum_quantity' => 2, 'unit_cost' => 35.94, 'location' => 'Shelf A-4'],
            ['name' => 'Cabin Air Filter', 'part_number' => 'CF-24048', 'category' => 'Filters', 'quantity_on_hand' => 8, 'minimum_quantity' => 4, 'unit_cost' => 15.99, 'location' => 'Shelf A-2'],
            ['name' => 'Fuel Filter', 'part_number' => 'FF-33311', 'category' => 'Filters', 'quantity_on_hand' => 6, 'minimum_quantity' => 4, 'unit_cost' => 24.99, 'location' => 'Shelf A-3'],
            ['name' => 'Tire P265/70R17', 'part_number' => 'TR-26570R17', 'category' => 'Tires', 'quantity_on_hand' => 2, 'minimum_quantity' => 4, 'unit_cost' => 189.99, 'location' => 'Tire Rack F-1'],
        ];
        foreach ($partsData as $p) {
            $parts[] = Part::create(array_merge($p, ['company_id' => $company->id]));
        }

        // === ASSETS ===
        $assets = [];
        $assetData = [
            // Vehicles
            ['name' => '2023 Ford F-150 XLT', 'type' => 'vehicle', 'make' => 'Ford', 'model' => 'F-150 XLT', 'year' => 2023, 'vin' => '1FTFW1E80NFA12345', 'license_plate' => 'TX-BF1234', 'status' => 'active', 'current_meter_value' => 34521, 'meter_unit' => 'miles', 'assigned_to' => $emily->id],
            ['name' => '2022 Chevy Silverado 1500', 'type' => 'vehicle', 'make' => 'Chevrolet', 'model' => 'Silverado 1500', 'year' => 2022, 'vin' => '3GCUYDED3NG234567', 'license_plate' => 'TX-CS5678', 'status' => 'active', 'current_meter_value' => 51238, 'meter_unit' => 'miles', 'assigned_to' => $jake->id],
            ['name' => '2024 Ram 1500 Big Horn', 'type' => 'vehicle', 'make' => 'Ram', 'model' => '1500 Big Horn', 'year' => 2024, 'vin' => '1C6SRFFT0PN345678', 'license_plate' => 'TX-RM9012', 'status' => 'active', 'current_meter_value' => 12450, 'meter_unit' => 'miles', 'assigned_to' => null],
            ['name' => '2021 Ford Transit 250', 'type' => 'vehicle', 'make' => 'Ford', 'model' => 'Transit 250', 'year' => 2021, 'vin' => '1FTBR1C83MKA56789', 'license_plate' => 'TX-FT3456', 'status' => 'in_shop', 'current_meter_value' => 78432, 'meter_unit' => 'miles', 'assigned_to' => null],
            ['name' => '2023 Toyota Tacoma TRD', 'type' => 'vehicle', 'make' => 'Toyota', 'model' => 'Tacoma TRD', 'year' => 2023, 'vin' => '3TMCZ5AN6PM678901', 'license_plate' => 'TX-TT7890', 'status' => 'active', 'current_meter_value' => 28915, 'meter_unit' => 'miles', 'assigned_to' => $mike->id],
            // Trailers
            ['name' => '2020 Utility Flatbed 24ft', 'type' => 'trailer', 'make' => 'Utility', 'model' => 'VS2DX Flatbed', 'year' => 2020, 'vin' => null, 'license_plate' => 'TX-TRL001', 'status' => 'active', 'current_meter_value' => 0, 'meter_unit' => 'miles', 'assigned_to' => null],
            ['name' => '2021 Enclosed Cargo 16ft', 'type' => 'trailer', 'make' => 'Cargo Express', 'model' => 'EX Series', 'year' => 2021, 'vin' => null, 'license_plate' => 'TX-TRL002', 'status' => 'active', 'current_meter_value' => 0, 'meter_unit' => 'miles', 'assigned_to' => null],
            ['name' => '2019 Equipment Hauler 20ft', 'type' => 'trailer', 'make' => 'PJ Trailers', 'model' => 'HD Equipment', 'year' => 2019, 'vin' => null, 'license_plate' => 'TX-TRL003', 'status' => 'out_of_service', 'current_meter_value' => 0, 'meter_unit' => 'miles', 'assigned_to' => null],
            // Equipment
            ['name' => 'CAT 320 Excavator', 'type' => 'equipment', 'make' => 'Caterpillar', 'model' => '320 GC', 'year' => 2022, 'vin' => null, 'license_plate' => null, 'status' => 'active', 'current_meter_value' => 2840, 'meter_unit' => 'hours', 'assigned_to' => null],
            ['name' => 'John Deere Z930M Mower', 'type' => 'equipment', 'make' => 'John Deere', 'model' => 'Z930M', 'year' => 2023, 'vin' => null, 'license_plate' => null, 'status' => 'active', 'current_meter_value' => 620, 'meter_unit' => 'hours', 'assigned_to' => null],
            ['name' => 'Honda EU7000iS Generator', 'type' => 'equipment', 'make' => 'Honda', 'model' => 'EU7000iS', 'year' => 2021, 'vin' => null, 'license_plate' => null, 'status' => 'active', 'current_meter_value' => 1450, 'meter_unit' => 'hours', 'assigned_to' => null],
            ['name' => 'Stihl MS 462 Chainsaw', 'type' => 'equipment', 'make' => 'Stihl', 'model' => 'MS 462', 'year' => 2022, 'vin' => null, 'license_plate' => null, 'status' => 'inactive', 'current_meter_value' => 380, 'meter_unit' => 'hours', 'assigned_to' => null],
        ];
        foreach ($assetData as $a) {
            $assets[] = Asset::create(array_merge($a, ['company_id' => $company->id]));
        }

        // === MAINTENANCE SCHEDULES ===
        $schedules = [
            ['asset_id' => $assets[0]->id, 'name' => 'Oil Change', 'schedule_type' => 'meter_based', 'frequency_value' => 5000, 'frequency_unit' => 'miles', 'last_completed_at' => now()->subDays(45), 'last_meter_value' => 30000, 'next_due_at' => null, 'next_due_meter' => 35000, 'status' => 'active'],
            ['asset_id' => $assets[0]->id, 'name' => 'Tire Rotation', 'schedule_type' => 'meter_based', 'frequency_value' => 7500, 'frequency_unit' => 'miles', 'last_completed_at' => now()->subDays(60), 'last_meter_value' => 27000, 'next_due_at' => null, 'next_due_meter' => 34500, 'status' => 'active'],
            ['asset_id' => $assets[1]->id, 'name' => 'Oil Change', 'schedule_type' => 'meter_based', 'frequency_value' => 5000, 'frequency_unit' => 'miles', 'last_completed_at' => now()->subDays(90), 'last_meter_value' => 46000, 'next_due_at' => null, 'next_due_meter' => 51000, 'status' => 'active'],
            ['asset_id' => $assets[1]->id, 'name' => 'Brake Inspection', 'schedule_type' => 'meter_based', 'frequency_value' => 15000, 'frequency_unit' => 'miles', 'last_completed_at' => now()->subDays(120), 'last_meter_value' => 40000, 'next_due_at' => null, 'next_due_meter' => 55000, 'status' => 'active'],
            ['asset_id' => $assets[2]->id, 'name' => 'Oil Change', 'schedule_type' => 'meter_based', 'frequency_value' => 5000, 'frequency_unit' => 'miles', 'last_completed_at' => now()->subDays(30), 'last_meter_value' => 10000, 'next_due_at' => null, 'next_due_meter' => 15000, 'status' => 'active'],
            ['asset_id' => $assets[3]->id, 'name' => 'Transmission Service', 'schedule_type' => 'meter_based', 'frequency_value' => 30000, 'frequency_unit' => 'miles', 'last_completed_at' => now()->subDays(200), 'last_meter_value' => 60000, 'next_due_at' => null, 'next_due_meter' => 90000, 'status' => 'active'],
            ['asset_id' => $assets[4]->id, 'name' => 'Oil Change', 'schedule_type' => 'meter_based', 'frequency_value' => 5000, 'frequency_unit' => 'miles', 'last_completed_at' => now()->subDays(20), 'last_meter_value' => 25000, 'next_due_at' => null, 'next_due_meter' => 30000, 'status' => 'active'],
            ['asset_id' => $assets[8]->id, 'name' => 'Hydraulic Fluid Change', 'schedule_type' => 'meter_based', 'frequency_value' => 500, 'frequency_unit' => 'hours', 'last_completed_at' => now()->subDays(50), 'last_meter_value' => 2500, 'next_due_at' => null, 'next_due_meter' => 3000, 'status' => 'active'],
            ['asset_id' => $assets[8]->id, 'name' => 'Track Inspection', 'schedule_type' => 'time_based', 'frequency_value' => 3, 'frequency_unit' => 'months', 'last_completed_at' => now()->subDays(80), 'last_meter_value' => null, 'next_due_at' => now()->subDays(10), 'next_due_meter' => null, 'status' => 'active'],
            ['asset_id' => $assets[9]->id, 'name' => 'Blade Sharpening', 'schedule_type' => 'meter_based', 'frequency_value' => 100, 'frequency_unit' => 'hours', 'last_completed_at' => now()->subDays(15), 'last_meter_value' => 550, 'next_due_at' => null, 'next_due_meter' => 650, 'status' => 'active'],
        ];
        foreach ($schedules as $s) {
            MaintenanceSchedule::create(array_merge($s, ['company_id' => $company->id]));
        }

        // === WORK ORDERS ===
        $wo1 = WorkOrder::create([
            'company_id' => $company->id, 'asset_id' => $assets[3]->id,
            'number' => 'WO-0001', 'title' => 'Brake system overhaul — Transit 250',
            'description' => 'Front and rear brake pads worn below spec. Rotors need resurfacing. Brake fluid flush required.',
            'priority' => 'high', 'status' => 'in_progress',
            'assigned_to' => $jake->id, 'vendor_id' => $vendors[0]->id,
            'started_at' => now()->subDays(2),
            'total_parts_cost' => 133.97, 'total_labor_cost' => 240.00,
            'created_by' => $mike->id,
        ]);
        WorkOrderPart::create(['work_order_id' => $wo1->id, 'part_id' => $parts[2]->id, 'part_name' => 'Brake Pads (Front)', 'quantity' => 1, 'unit_cost' => 45.99]);
        WorkOrderPart::create(['work_order_id' => $wo1->id, 'part_id' => $parts[3]->id, 'part_name' => 'Brake Pads (Rear)', 'quantity' => 1, 'unit_cost' => 42.99]);
        WorkOrderPart::create(['work_order_id' => $wo1->id, 'part_id' => $parts[6]->id, 'part_name' => 'Brake Fluid', 'quantity' => 3, 'unit_cost' => 14.99]);
        WorkOrderLabor::create(['work_order_id' => $wo1->id, 'technician_id' => $jake->id, 'description' => 'Remove and replace brake pads, resurface rotors', 'hours' => 3.0, 'hourly_rate' => 80.00]);

        $wo2 = WorkOrder::create([
            'company_id' => $company->id, 'asset_id' => $assets[0]->id,
            'number' => 'WO-0002', 'title' => 'Scheduled oil change — F-150',
            'description' => 'Routine 5,000 mile oil change. Replace oil filter, top off fluids.',
            'priority' => 'low', 'status' => 'completed',
            'assigned_to' => $jake->id,
            'started_at' => now()->subDays(10), 'completed_at' => now()->subDays(10),
            'total_parts_cost' => 53.91, 'total_labor_cost' => 40.00,
            'created_by' => $sarah->id,
        ]);
        WorkOrderPart::create(['work_order_id' => $wo2->id, 'part_id' => $parts[0]->id, 'part_name' => 'Oil Filter', 'quantity' => 1, 'unit_cost' => 8.99]);
        WorkOrderPart::create(['work_order_id' => $wo2->id, 'part_id' => $parts[5]->id, 'part_name' => 'Synthetic Oil 5W-30', 'quantity' => 6, 'unit_cost' => 7.49]);
        WorkOrderLabor::create(['work_order_id' => $wo2->id, 'technician_id' => $jake->id, 'description' => 'Drain oil, replace filter, refill', 'hours' => 0.5, 'hourly_rate' => 80.00]);

        $wo3 = WorkOrder::create([
            'company_id' => $company->id, 'asset_id' => $assets[1]->id,
            'number' => 'WO-0003', 'title' => 'Replace headlight assembly — Silverado',
            'description' => 'Driver side headlight flickering. Replace bulb, check wiring harness.',
            'priority' => 'medium', 'status' => 'open',
            'assigned_to' => $jake->id,
            'total_parts_cost' => 0, 'total_labor_cost' => 0,
            'created_by' => $emily->id,
        ]);

        $wo4 = WorkOrder::create([
            'company_id' => $company->id, 'asset_id' => $assets[8]->id,
            'number' => 'WO-0004', 'title' => 'Hydraulic leak repair — CAT 320',
            'description' => 'Slow hydraulic leak detected at boom cylinder. Seal replacement needed.',
            'priority' => 'critical', 'status' => 'open',
            'assigned_to' => null, 'vendor_id' => $vendors[3]->id,
            'total_parts_cost' => 0, 'total_labor_cost' => 0,
            'created_by' => $mike->id,
        ]);

        $wo5 = WorkOrder::create([
            'company_id' => $company->id, 'asset_id' => $assets[4]->id,
            'number' => 'WO-0005', 'title' => 'Tire replacement (2) — Tacoma',
            'description' => 'Rear tires at 3/32" tread depth. Replace both rears.',
            'priority' => 'medium', 'status' => 'completed',
            'assigned_to' => $jake->id, 'vendor_id' => $vendors[1]->id,
            'started_at' => now()->subDays(5), 'completed_at' => now()->subDays(5),
            'total_parts_cost' => 379.98, 'total_labor_cost' => 80.00,
            'created_by' => $mike->id,
        ]);
        WorkOrderPart::create(['work_order_id' => $wo5->id, 'part_id' => $parts[14]->id, 'part_name' => 'Tire P265/70R17', 'quantity' => 2, 'unit_cost' => 189.99]);
        WorkOrderLabor::create(['work_order_id' => $wo5->id, 'technician_id' => $jake->id, 'description' => 'Mount and balance 2 tires', 'hours' => 1.0, 'hourly_rate' => 80.00]);

        $wo6 = WorkOrder::create([
            'company_id' => $company->id, 'asset_id' => $assets[2]->id,
            'number' => 'WO-0006', 'title' => 'Air filter replacement — Ram 1500',
            'description' => 'Scheduled air filter change at 10,000 miles.',
            'priority' => 'low', 'status' => 'completed',
            'assigned_to' => $jake->id,
            'started_at' => now()->subDays(15), 'completed_at' => now()->subDays(15),
            'total_parts_cost' => 18.49, 'total_labor_cost' => 20.00,
            'created_by' => $sarah->id,
        ]);

        $wo7 = WorkOrder::create([
            'company_id' => $company->id, 'asset_id' => $assets[10]->id,
            'number' => 'WO-0007', 'title' => 'Generator annual service — Honda EU7000iS',
            'description' => 'Annual service: oil change, air filter, spark plug, valve adjustment check.',
            'priority' => 'medium', 'status' => 'on_hold',
            'assigned_to' => null,
            'total_parts_cost' => 0, 'total_labor_cost' => 0,
            'created_by' => $mike->id,
        ]);

        $wo8 = WorkOrder::create([
            'company_id' => $company->id, 'asset_id' => $assets[7]->id,
            'number' => 'WO-0008', 'title' => 'Trailer deck repair — Equipment Hauler',
            'description' => 'Several deck boards cracked and rotting. Replace damaged boards, inspect frame.',
            'priority' => 'high', 'status' => 'open',
            'assigned_to' => null, 'vendor_id' => $vendors[0]->id,
            'total_parts_cost' => 0, 'total_labor_cost' => 0,
            'created_by' => $sarah->id,
        ]);

        // === INSPECTIONS ===
        $insp1 = Inspection::create([
            'company_id' => $company->id, 'asset_id' => $assets[0]->id,
            'template_name' => 'Pre-Trip Inspection', 'inspector_id' => $emily->id,
            'status' => 'passed', 'completed_at' => now()->subDays(1),
        ]);
        $preTrip = ['Tires & Wheels', 'Lights & Reflectors', 'Mirrors', 'Horn', 'Wipers & Washers', 'Steering', 'Brakes', 'Seat Belt', 'Fire Extinguisher', 'Emergency Kit'];
        foreach ($preTrip as $i => $label) {
            InspectionItem::create(['inspection_id' => $insp1->id, 'label' => $label, 'result' => 'pass', 'sort_order' => $i + 1]);
        }

        $insp2 = Inspection::create([
            'company_id' => $company->id, 'asset_id' => $assets[3]->id,
            'template_name' => 'Pre-Trip Inspection', 'inspector_id' => $jake->id,
            'status' => 'failed', 'completed_at' => now()->subDays(3),
            'notes' => 'Vehicle pulled into shop for brake work based on this inspection.',
        ]);
        foreach ($preTrip as $i => $label) {
            $result = $label === 'Brakes' ? 'fail' : 'pass';
            $notes = $label === 'Brakes' ? 'Grinding noise on front brakes, pedal feels spongy' : null;
            InspectionItem::create(['inspection_id' => $insp2->id, 'label' => $label, 'result' => $result, 'notes' => $notes, 'sort_order' => $i + 1]);
        }

        $insp3 = Inspection::create([
            'company_id' => $company->id, 'asset_id' => $assets[8]->id,
            'template_name' => 'Heavy Equipment Safety Check', 'inspector_id' => $jake->id,
            'status' => 'failed', 'completed_at' => now()->subDays(5),
            'notes' => 'Hydraulic leak found — work order created.',
        ]);
        $heavyEquip = ['Hydraulic System', 'Tracks/Undercarriage', 'Boom & Stick', 'Bucket', 'Cab & Controls', 'Engine Compartment', 'Electrical', 'Safety Decals'];
        foreach ($heavyEquip as $i => $label) {
            $result = $label === 'Hydraulic System' ? 'fail' : ($label === 'Safety Decals' ? 'na' : 'pass');
            $notes = $label === 'Hydraulic System' ? 'Visible leak at boom cylinder seal' : null;
            InspectionItem::create(['inspection_id' => $insp3->id, 'label' => $label, 'result' => $result, 'notes' => $notes, 'sort_order' => $i + 1]);
        }

        $insp4 = Inspection::create([
            'company_id' => $company->id, 'asset_id' => $assets[1]->id,
            'template_name' => 'Pre-Trip Inspection', 'inspector_id' => $emily->id,
            'status' => 'passed', 'completed_at' => now(),
        ]);
        foreach ($preTrip as $i => $label) {
            InspectionItem::create(['inspection_id' => $insp4->id, 'label' => $label, 'result' => 'pass', 'sort_order' => $i + 1]);
        }

        $insp5 = Inspection::create([
            'company_id' => $company->id, 'asset_id' => $assets[5]->id,
            'template_name' => 'Trailer Inspection', 'inspector_id' => $jake->id,
            'status' => 'passed', 'completed_at' => now()->subDays(7),
        ]);
        $trailer = ['Hitch & Coupler', 'Safety Chains', 'Lights', 'Tires', 'Deck/Floor', 'Tie-Down Points'];
        foreach ($trailer as $i => $label) {
            InspectionItem::create(['inspection_id' => $insp5->id, 'label' => $label, 'result' => 'pass', 'sort_order' => $i + 1]);
        }

        $insp6 = Inspection::create([
            'company_id' => $company->id, 'asset_id' => $assets[4]->id,
            'template_name' => 'Pre-Trip Inspection', 'inspector_id' => $emily->id,
            'status' => 'pending',
        ]);

        // === DOCUMENTS ===
        Document::create(['company_id' => $company->id, 'documentable_type' => 'App\\Models\\Asset', 'documentable_id' => $assets[0]->id, 'title' => 'Vehicle Registration - F-150', 'file_path' => 'documents/registration-f150.pdf', 'file_type' => 'pdf', 'expires_at' => now()->addMonths(8), 'uploaded_by' => $sarah->id]);
        Document::create(['company_id' => $company->id, 'documentable_type' => 'App\\Models\\Asset', 'documentable_id' => $assets[0]->id, 'title' => 'Insurance Certificate - F-150', 'file_path' => 'documents/insurance-f150.pdf', 'file_type' => 'pdf', 'expires_at' => now()->addDays(15), 'uploaded_by' => $sarah->id]);
        Document::create(['company_id' => $company->id, 'documentable_type' => 'App\\Models\\Asset', 'documentable_id' => $assets[1]->id, 'title' => 'Vehicle Registration - Silverado', 'file_path' => 'documents/registration-silverado.pdf', 'file_type' => 'pdf', 'expires_at' => now()->addMonths(4), 'uploaded_by' => $sarah->id]);
        Document::create(['company_id' => $company->id, 'documentable_type' => 'App\\Models\\Asset', 'documentable_id' => $assets[3]->id, 'title' => 'Vehicle Registration - Transit', 'file_path' => 'documents/registration-transit.pdf', 'file_type' => 'pdf', 'expires_at' => now()->subDays(10), 'uploaded_by' => $sarah->id]);
        Document::create(['company_id' => $company->id, 'documentable_type' => 'App\\Models\\WorkOrder', 'documentable_id' => $wo1->id, 'title' => 'Brake Inspection Report', 'file_path' => 'documents/brake-report-wo1.pdf', 'file_type' => 'pdf', 'expires_at' => null, 'uploaded_by' => $jake->id]);
        Document::create(['company_id' => $company->id, 'documentable_type' => null, 'documentable_id' => null, 'title' => 'Fleet Safety Policy 2026', 'file_path' => 'documents/safety-policy-2026.pdf', 'file_type' => 'pdf', 'expires_at' => now()->addMonths(12), 'uploaded_by' => $sarah->id]);
    }
}
