<?php

namespace App\Controller;

use App\Model\DescriptionGameModel;
use App\Model\DescritptionGameStatusModel;

class GameStatusController extends AbstractController
{
    private DescriptionGameModel $gameModel;
    private DescritptionGameStatusModel $statusModel;

    public function __construct()
    {
        $this->gameModel = new DescriptionGameModel();
        $this->statusModel = new DescritptionGameStatusModel();
    }

    public function changeStatusGame($gameId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $gameStatus = $this->statusModel->selectGameStatusFromUserId($gameId, $this->gameModel->getUserId());
            $status = array_keys($_POST);
            if ($gameStatus['status'] === str_replace("_", " ", $status[0])) {
                $valueStatus = 1;
            } else {
                $valueStatus = 0;
            }
            if (!$gameStatus) {
                $this->statusModel->addStatusGameByUserId(
                    str_replace("_", " ", $status[$valueStatus]),
                    $gameId,
                    $this->gameModel->getUserId()
                );
            } else {
                $this->statusModel->updateStatusGameByUserId(
                    str_replace("_", " ", $status[$valueStatus]),
                    $gameId,
                    $this->gameModel->getUserId()
                );
            }
            return false;
        }
        return true;
    }

    public function getStatusGame($gameId)
    {
        $statusGame = $this->statusModel->selectGameStatusFromUserId($gameId, $this->gameModel->getUserId());
        if (!$statusGame) {
            return [["checked", "A Faire", "wished"], ["", "En Cours", "in progress"], ["", "Terminé", "finished"]];
        } elseif ($statusGame['status'] === 'wished') {
            return [["checked", "A Faire", "wished"], ["", "En Cours", "in progress"], ["", "Terminé", "finished"]];
        } elseif ($statusGame['status'] === 'in progress') {
            return [["", "A Faire", "wished"], ["checked", "En Cours", "in progress"], ["", "Terminé", "finished"]];
        } else {
            return [["", "A Faire", "wished"], ["", "En Cours", "in progress"], ['checked', 'Terminé', "finished"]];
        }
    }

    public function getStatusGameReview($gameId)
    {
        $userReview = $this->gameModel->selectGameReviewFromUserId($gameId, $this->gameModel->getUserId());
        if (!$userReview) {
            return ['outline-', 'outline-'];
        } elseif ($userReview['like'] === 'like') {
            return ['', 'outline-'];
        } else {
            return ['outline-', ''];
        }
    }
    public function getCheckedRequestGet($id)
    {
        $status = false;
        if (isset($_SESSION['username'])) {
            $status = $this->statusModel->selectGameStatusFromUserId($id, $this->gameModel->getUserId());
        }
        if (!$status) {
            return ['checked', '', ''];
        } else {
            if ($status['status'] === 'wished') {
                return ['checked', '', ''];
            } elseif ($status['status'] === 'in progress') {
                return ['', 'checked', ''];
            } else {
                return ['', '', 'checked'];
            }
        }
    }
}
