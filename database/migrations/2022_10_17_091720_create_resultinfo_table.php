<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultinfo', function (Blueprint $table) {
            $table->id();

            $table->string("result_scope")->default("school"); // School, Classroom, Student

            //EFFECTIVE-SKILLS: 
            $table->tinyInteger("effective_punctuality");
            $table->tinyInteger("effective_politeness");
            $table->tinyInteger("effective_neatness");
            $table->tinyInteger("effective_honesty");
            $table->tinyInteger("effective_leadership_skill");
            $table->tinyInteger("effective_cooperation");
            $table->tinyInteger("effective_attentiveness");
            $table->tinyInteger("effective_perseverance");
            $table->tinyInteger("effective_attitude_to_work");
            	
            //PSYCHOMOTOR-SKILLS: 
            $table->tinyInteger("psychomotor_handwriting");
            $table->tinyInteger("psychomotor_verbal_fluency");
            $table->tinyInteger("psychomotor_sport");
            $table->tinyInteger("psychomotor_handling_tools");
            $table->tinyInteger("psychomotor_drawing_and_painting");
            $table->tinyInteger("psychomotor_cooperation");
            $table->tinyInteger("psychomotor_attentiveness");
            $table->tinyInteger("psychomotor_perseverance");
            $table->tinyInteger("psychomotor_attitude_to_work");

            //COMMENTS: 
            $table->text("form_master_comment");
            $table->text("principal_comment");

            //MESSAGES: 
            $table->text("message_to_parent");
            $table->text("message_to_student");
            $table->text("message_to_staff");

            //SCHOOL-FEES:
            $table->integer("debt");
            $table->integer("next_term_school_fees");

            //OTHERS:
            $table->boolean("hold_result")->default(true);
            $table->string("reason_for_holding_result")->default("Not released yet.");

            $table->bigInteger('section_id')->unsigned(); 
            $table->bigInteger('owner_id')->unsigned(); // User_id, classroom_id, school_id
            $table->string('user_number'); // Student number
            $table->string("session");
            $table->string("term");
            $table->string("next_term_begins_on");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resultinfo');
    }
}
