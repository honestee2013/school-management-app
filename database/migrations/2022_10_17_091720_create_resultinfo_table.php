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
        Schema::create('resultinfos', function (Blueprint $table) {
            $table->id();

            $table->string('user_number')->nullable(); // Student number
            $table->string("result_scope")->default("school"); // School, Classroom, Student
            $table->string("session");
            $table->string("term");

            //OTHERS:
            $table->boolean("hold_result")->default(true);
            $table->string("reason_for_holding_result")->default("Not released yet.");

            $table->bigInteger('section_id')->unsigned(); 
            $table->bigInteger('owner')->unsigned(); // User_id, classroom_id, school_id

            //SCHOOL-FEES:
            $table->integer("debt")->default(0);
            $table->integer("next_term_school_fees")->default(0);

            //COMMENTS: 
            $table->text("form_master_comment")->nullable();
            $table->text("principal_comment")->nullable();

            //MESSAGES: 
            $table->text("message_to_parent")->nullable();
            $table->text("message_to_student")->nullable();
            $table->text("message_to_staff")->nullable();

            //EFFECTIVE-SKILLS: 
            $table->tinyInteger("effective_punctuality")->default(3);
            $table->tinyInteger("effective_politeness")->default(3);
            $table->tinyInteger("effective_neatness")->default(3);
            $table->tinyInteger("effective_honesty")->default(3);
            $table->tinyInteger("effective_leadership_skill")->default(3);
            $table->tinyInteger("effective_cooperation")->default(3);
            $table->tinyInteger("effective_attentiveness")->default(3);
            $table->tinyInteger("effective_perseverance")->default(3);
            $table->tinyInteger("effective_attitude_to_work")->default(3);
            	
            //PSYCHOMOTOR-SKILLS: 
            $table->tinyInteger("psychomotor_handwriting")->default(3);
            $table->tinyInteger("psychomotor_verbal_fluency")->default(3);
            $table->tinyInteger("psychomotor_sport")->default(3);
            $table->tinyInteger("psychomotor_handling_tools")->default(3);
            $table->tinyInteger("psychomotor_drawing_and_painting")->default(3);
            $table->tinyInteger("psychomotor_cooperation")->default(3);
            $table->tinyInteger("psychomotor_attentiveness")->default(3);
            $table->tinyInteger("psychomotor_perseverance")->default(3);;
            $table->tinyInteger("psychomotor_attitude_to_work")->default(3);


            $table->string("next_term_begins_on")->nullable();

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
        Schema::dropIfExists('resultinfos');
    }
}
