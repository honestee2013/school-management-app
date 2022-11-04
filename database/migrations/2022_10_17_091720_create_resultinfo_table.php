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

            $table->string("result_scope")->default("school"); // School, Classroom, Student
            $table->string('user_number')->defaults(""); // Student number
            $table->string("session");
            $table->string("term");

            //OTHERS:
            $table->boolean("hold_result")->default(true);
            $table->string("reason_for_holding_result")->default("Not released yet.");

            $table->bigInteger('section_id')->unsigned(); 
            $table->bigInteger('owner')->unsigned(); // User_id, classroom_id, school_id

            //SCHOOL-FEES:
            $table->integer("debt")->defaults(0);
            $table->integer("next_term_school_fees")->defaults(0);

            //COMMENTS: 
            $table->text("form_master_comment")->defaults("");
            $table->text("principal_comment")->defaults("");

            //MESSAGES: 
            $table->text("message_to_parent")->defaults("");
            $table->text("message_to_student")->defaults("");
            $table->text("message_to_staff")->defaults("");

            //EFFECTIVE-SKILLS: 
            $table->tinyInteger("effective_punctuality")->defaults(3);
            $table->tinyInteger("effective_politeness")->defaults(3);
            $table->tinyInteger("effective_neatness")->defaults(3);
            $table->tinyInteger("effective_honesty")->defaults(3);
            $table->tinyInteger("effective_leadership_skill")->defaults(3);
            $table->tinyInteger("effective_cooperation")->defaults(3);
            $table->tinyInteger("effective_attentiveness")->defaults(3);
            $table->tinyInteger("effective_perseverance")->defaults(3);
            $table->tinyInteger("effective_attitude_to_work")->defaults(3);
            	
            //PSYCHOMOTOR-SKILLS: 
            $table->tinyInteger("psychomotor_handwriting")->defaults(3);
            $table->tinyInteger("psychomotor_verbal_fluency")->defaults(3);
            $table->tinyInteger("psychomotor_sport")->defaults(3);
            $table->tinyInteger("psychomotor_handling_tools")->defaults(3);
            $table->tinyInteger("psychomotor_drawing_and_painting")->defaults(3);
            $table->tinyInteger("psychomotor_cooperation")->defaults(3);
            $table->tinyInteger("psychomotor_attentiveness")->defaults(3);
            $table->tinyInteger("psychomotor_perseverance")->defaults(3);;
            $table->tinyInteger("psychomotor_attitude_to_work")->defaults(3);


            $table->string("next_term_begins_on")->defaults("");

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
