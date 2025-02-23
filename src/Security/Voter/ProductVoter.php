<?php

namespace App\Security\Voter;

use App\Entity\Product;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ProductVoter extends Voter
{
    public const VIEW = 'product_view';
    public const EDIT = 'product_edit';
    public const DELETE = 'product_delete';
    public const ADD = 'product_add';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::VIEW, self::EDIT, self::DELETE, self::ADD])
            && ($subject instanceof Product || $subject === null); 
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($attribute === self::VIEW) {
            return in_array('ROLE_ADMIN', $user->getRoles());
        }

        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return true;
        }

        return false;
    }
}
