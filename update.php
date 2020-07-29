<?php

	require_once 'source/User.php';
	require_once 'source/Challenge.php';
	require_once 'source/Contest.php';
	require_once 'source/Achievement.php';

	/* Update all active challenges status and declare winner */
	$challenge = new Challenge();

	$challengesData = $challenge->getActiveChallenges();

	foreach ($challengesData as $challengeData)
	{
				$now = new DateTime();
				$chExpireAt = new DateTime($challengeData['ExpireAt']);

				if ($now > $chExpireAt)
				{
						$challenge->setStatus($challengeData['Code'], 1);

						if ($challenge->countParticipants($challengeData['Code']) >= 2)
						{
								$Winner = $challenge->getLeader($challengeData['Code']);
								$challenge->setWinner($challengeData['Code'], $Winner);

								$user = new User();
				        $user->giveXP($Winner, 140);

				        $achievement = new Achievement();

				        $wonChlgsByWinner = $user->countWonChallenges($Winner);

				        if ($wonChlgsByWinner == 1)
				        {
				          	if (!$achievement->hasUserUnlocked($Winner, 13))
				          			$achievement->unlock($Winner, 13);
				        }
				        else if ($wonChlgsByWinner == 5)
				        {
				        	 	if (!$achievement->hasUserUnlocked($Winner, 14))
					      			 	$achievement->unlock($Winner, 14);
				        }
				        else if ($wonChlgsByWinner == 25)
				        {
										if (!$achievement->hasUserUnlocked($Winner, 15))
												$achievement->unlock($Winner, 15);
				        }
				    }
				}
	}

	/* Update all contests stats and declare winner */
	$contest = new Contest();

	$contestsData = $contest->getAllActive();

	foreach ($contestsData as $contestData)
	{
				$now = new DateTime();

				if ($contestData['Status'] == 0)
				{
						$contestStartAt = new DateTime($contestData['SDateTime']);

						/* Start contest */
						if ($contestStartAt <= $now)
								$contest->setStatus($contestData['ID'], 1);
				}
				else if ($contestData['Status'] == 1)
				{
						$contestStartedAt = new DateTime($contestData['SDateTime']);
						$contestTime = $contestData['Length'] + 3;

						/* Finish contest */
						if ($contestStartedAt->modify('+'.$contestTime.' minutes') <= $now)
						{
								$contest->setStatus($contestData['ID'], 2);

								$Winner = $contest->getLeader($contestData['ID']);
								$contest->setWinner($contestData['ID'], $Winner);

								if (!$achievement->hasUserUnlocked($Winner, 19))
										$achievement->unlock($Winner, 19);

								$user = new User();
								$user->giveCoins($Winner, $contestData['Prize']);
								$user->giveTrophy($Winner);

								$CMD = $challenge->db->prepare("UPDATE `questions` SET `Blocked` = 0 WHERE `Contest` = :Contest");
								$CMD->bindParam(':Contest', $contestData['ID']);

								$CMD->execute();
						}
				}
	}

?>
