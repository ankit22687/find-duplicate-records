<?php

namespace Tests\Feature;

use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MergeRecordsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_merge_duplicate_doctors()
    {
        // Create duplicate clinics
        $clinic1 = Clinic::factory()->create();
        $clinic2 = Clinic::factory()->create();

        // Create duplicate doctors
        $duplicateDoctor1 = Doctor::factory()->for($clinic1)->create(['name' => 'John Doe', 'specialty' => 'GP']);
        $duplicateDoctor2 = Doctor::factory()->for($clinic2)->create(['name' => 'John Doe', 'specialty' => 'GP']);

        // Create tests associated with the doctors
        Test::factory()->create([
            'referring_doctor_id' => $duplicateDoctor1->id,
        ]);
        Test::factory()->create([
            'referring_doctor_id' => $duplicateDoctor2->id,
        ]);

        $response = $this->get('/find-duplicate-records/doctors');

        $response->assertStatus(200);

        $response->assertViewHas('duplicateRecords');

        $response->assertSeeText('John Doe');

        // Assert that two doctors exists
        $this->assertEquals(2, Doctor::count());

        $mergeResponse = $this->post('/merge-duplicate-records', [
            'type' => 'doctors',
        ]);

        $this->followRedirects($mergeResponse)->assertSee('Doctors merged successfully');

        // Assert that only one doctor exists
        $this->assertEquals(1, Doctor::count());

        // Assert that the tests are now associated with the merged doctor
        $this->assertEquals(2, DB::table('tests')->where('referring_doctor_id', $duplicateDoctor1->id)->count());
    }

    /** @test */
    public function it_can_merge_duplicate_clinics()
    {
        // Create duplicate clinics
        $clinic1 = Clinic::factory()->create(['name' => 'Abbott LLC', 'address' => '737C Jan Byway, South Candace, VIC 2940']);
        $clinic2 = Clinic::factory()->create(['name' => 'Abbott LLC', 'address' => '737C Jan Byway, South Candace, VIC 2940']);

        // Create duplicate doctors
        $duplicateDoctor1 = Doctor::factory()->for($clinic1)->create();
        $duplicateDoctor2 = Doctor::factory()->for($clinic2)->create();

        $response = $this->get('/find-duplicate-records/clinics');

        $response->assertStatus(200);

        $response->assertViewHas('duplicateRecords');

        $response->assertSeeText('Abbott LLC');

        // Assert that two clinics exists
        $this->assertEquals(2, Clinic::count());

        $mergeResponse = $this->post('/merge-duplicate-records', [
            'type' => 'clinics',
        ]);

        $this->followRedirects($mergeResponse)->assertSee('Clinics merged successfully');

        // Assert that only one clinic exists
        $this->assertEquals(1, Clinic::count());

        // Assert that the doctors are now associated with the merged clinic
        $this->assertEquals(2, DB::table('doctors')->where('clinic_id', $duplicateDoctor1->id)->count());
    }
}
