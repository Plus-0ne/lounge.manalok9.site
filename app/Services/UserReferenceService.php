<?php

namespace App\Services;

use App\Models\Users\MembersModel;

class UserReferenceService
{
    const MAX_REFERENCES_DEPTH = 7;

    public function getUserReferences(string $iagd_number)
    {
        $user = MembersModel::where('iagd_number', $iagd_number)
            ->select('uuid', 'first_name', 'middle_name', 'last_name', 'profile_image')
            ->first();

        if (!$user) {
            return [
                'error' => [
                    'message' => 'User not found.',
                ]
            ];
        }

        // Fetch all members
        $allMembers = MembersModel::select('uuid', 'iagd_number', 'first_name', 'middle_name', 'last_name', 'profile_image', 'referred_by')
            ->get()
            ->keyBy('iagd_number')
            ->toArray();

        $deepest_reference_level = 0;
        $total_referrals_at_each_level = array_fill(1, self::MAX_REFERENCES_DEPTH, 0);
        $user_with_most_referrals = ['iagd_number' => null, 'referrals' => 0];

        $references_array = $this->getNestedReferences($allMembers, $iagd_number, $deepest_reference_level, $total_referrals_at_each_level, $user_with_most_referrals, 1);

        $uplineData = $this->getUplineData($iagd_number);

        $meta = [
            'queried_user' => $user,
            'total_references' => count($references_array),
            'deepest_reference_level' => $deepest_reference_level,
            'total_referrals_at_each_level' => $total_referrals_at_each_level,
            'user_with_most_referrals' => $user_with_most_referrals['iagd_number'],
            'timestamp' => now()
        ];

        return [
            'downline_data' => $references_array,
            'upline_data' => $uplineData,
            'data' => $references_array,
            'meta' => $meta
        ];
    }

    private function getNestedReferences(&$allMembers, $current_iagd_number, &$deepest_reference_level, &$total_referrals_at_each_level, &$user_with_most_referrals, $level)
    {
        $references_array = [];

        if ($level > self::MAX_REFERENCES_DEPTH) {
            return $references_array;
        }

        foreach ($allMembers as $iagd_number => $member) {
            if ($member['referred_by'] === $current_iagd_number) {
                if ($level > $deepest_reference_level) {
                    $deepest_reference_level = $level;
                }

                $member['level'] = $level;
                $references_array[] = $member;

                $referralCount = 0;
                foreach ($allMembers as $potentialReferral) {
                    if ($potentialReferral['referred_by'] === $iagd_number) {
                        $referralCount++;
                    }
                }

                if ($referralCount > $user_with_most_referrals['referrals']) {
                    $user_with_most_referrals = ['iagd_number' => $iagd_number, 'referrals' => $referralCount];
                }

                $total_referrals_at_each_level[$level]++;
                $inner_references = $this->getNestedReferences($allMembers, $iagd_number, $deepest_reference_level, $total_referrals_at_each_level, $user_with_most_referrals, $level + 1);
                $references_array = array_merge($references_array, $inner_references);
            }
        }

        return $references_array;
    }

    private function getUplineData($iagd_number)
    {
        $uplineData = [];
        $level = 0;
        $referred_by = MembersModel::where('iagd_number', $iagd_number)->value('referred_by');

        while ($referred_by !== null && $level < self::MAX_REFERENCES_DEPTH) {
            $user = MembersModel::where('iagd_number', $referred_by)
                ->select('uuid', 'iagd_number', 'first_name', 'middle_name', 'last_name', 'profile_image', 'referred_by')
                ->first();

            if (!$user) {
                break;
            }

            $user->level = ++$level;
            $uplineData[] = $user;
            $referred_by = $user->referred_by;
        }

        return $uplineData;
    }
}