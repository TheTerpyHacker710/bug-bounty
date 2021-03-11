<?php


namespace App\Services\VerificationAssigners;



class BasicVerificationAssigner extends VerificationAssigner
{
    // return 3 random assignees
    protected function selectVerifiers($query)
    {
        return $query->inRandomOrder()->limit(3)->get();
    }
}


//        $eligibleUsersIds = $eligibleUsers->map(function($user) {
//           return $user->id;
//        });
//
//        print_r($eligibleUsersIds);
//
//        $randomOldUser = $eligibleUsers->first();
//
//        print_r($randomOldUser->id);
//
//        VerificationAssignment::create([
//            'verification_batch_id' => $verificationBatch->id,
//            'assignee_id' => $randomOldUser->id,
//            'status' => 'pending',
//        ]);
////
//        // users are eligible if they have never been assigned to this report
//        $eligibleUsers2 = User::whereDoesntHave('verificationAssignments.verificationBatch.report', function ($query) use ($verificationBatch) {
//            $query->where('id', $verificationBatch->report_id);
//        })->inRandomOrder()->get();
//
//        $abc = $eligibleUsers2->map(function($user) {
//            return $user->id;
//        });
//
//        print_r($abc);

        //return "Hello from Basic Verification Assigner!";

//public function assignVerifiers(Report $report)
//    {
//        // users are eligible if they have never been assigned to this report
//        $eligibleUsers = User::whereDoesntHave('verificationAssignments.verificationBatch.report', function ($query) use ($verificationBatch) {
//            $query->where('id', $verificationBatch->report_id);
//        // and did not create this report
//        })->whereDoesntHave('reports', function($query) use ($verificationBatch) {
//            $query->where('id', $verificationBatch->report_id);
//        });
//
//        // randomly assign eligible users
//        $assignees = $eligibleUsers->inRandomOrder()->limit(3)->get();
//
//        // create verification assignment for each user
//        foreach ($assignees as $assignee) {
//            VerificationAssignment::create([
//                'verification_batch_id' => $verificationBatch->id,
//                'assignee_id' => $assignee->id,
//                'status' => 'pending',
//            ]);
//        }
//    }