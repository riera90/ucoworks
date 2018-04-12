<?php

namespace App\Security\Voter;

use App\Entity\Student;
use App\Entity\Subject;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class SubjectVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['ENROLL', 'UNENROLL'])
            && $subject instanceof Subject;
    }

    /**
     * @param string $attribute
     * @param Subject $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        $students = $subject->getStudents()->filter(function (Student $student) use ($user) {
            return $student->getId() === $user->getId();
        });

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'ENROLL':
                return $students->isEmpty();
                break;
            case 'UNENROLL':
                return !$students->isEmpty();
                break;
        }

        return false;
    }
}
