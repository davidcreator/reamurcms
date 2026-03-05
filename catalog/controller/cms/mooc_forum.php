<?php
namespace Reamur\Catalog\Controller\Cms;

class MoocForum extends \Reamur\System\Engine\Controller {
    public function index(): void {
        $this->load->language('cms/mooc');
        $this->load->model('cms/mooc_forum');

        $course_id = (int)($this->request->get['course_id'] ?? 0);
        if (!$course_id) {
            $this->response->redirect($this->url->link('cms/mooc'));
            return;
        }
        $page = (int)($this->request->get['page'] ?? 1);
        $limit = 20;
        $start = ($page - 1) * $limit;

        $data['topics'] = $this->model_cms_mooc_forum->getTopics($course_id, $start, $limit);
        $data['course_id'] = $course_id;
        $data['heading_title'] = $this->language->get('text_forum');
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_new_topic'] = $this->language->get('text_new_topic');
        $data['user_token'] = '';
        $data['action_topic'] = $this->url->link('cms/mooc_forum.addTopic', 'course_id=' . $course_id);
        $data['login_link'] = $this->url->link('account/login');
        $data['customer_logged'] = $this->customer->isLogged();

        $this->response->setOutput($this->load->view('cms/mooc_forum_list', $data));
    }

    public function topic(): void {
        $this->load->language('cms/mooc');
        $this->load->model('cms/mooc_forum');

        $topic_id = (int)($this->request->get['topic_id'] ?? 0);
        $topic = $this->model_cms_mooc_forum->getTopic($topic_id);
        if (!$topic) {
            $this->response->redirect($this->url->link('cms/mooc'));
            return;
        }

        $data['topic'] = $topic;
        $data['replies'] = $this->model_cms_mooc_forum->getReplies($topic_id);
        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_reply'] = $this->language->get('text_reply');
        $data['text_solution'] = $this->language->get('text_solution');
        $data['course_link'] = $this->url->link('cms/mooc.info', 'course_id=' . $topic['course_id']);
        $data['action_reply'] = $this->url->link('cms/mooc_forum.reply', 'topic_id=' . $topic_id);
        $data['action_like'] = $this->url->link('cms/mooc_forum.like', 'topic_id=' . $topic_id);
        $data['action_solution'] = $this->url->link('cms/mooc_forum.solution', 'topic_id=' . $topic_id);
        $data['customer_logged'] = $this->customer->isLogged();
        $data['login_link'] = $this->url->link('account/login');

        $this->response->setOutput($this->load->view('cms/mooc_forum_topic', $data));
    }

    public function addTopic(): void {
        if (!$this->customer->isLogged()) {
            $this->response->redirect($this->url->link('account/login'));
            return;
        }
        $course_id = (int)$this->request->post['course_id'];
        $title = trim($this->request->post['title'] ?? '');
        $body = trim($this->request->post['body'] ?? '');
        if ($course_id && $title && $body) {
            $this->load->model('cms/mooc_forum');
            $topic_id = $this->model_cms_mooc_forum->addTopic($course_id, $this->customer->getId(), $title, $body);
            $this->response->redirect($this->url->link('cms/mooc_forum.topic', 'topic_id=' . $topic_id));
            return;
        }
        $this->response->redirect($this->url->link('cms/mooc_forum', 'course_id=' . $course_id));
    }

    public function reply(): void {
        if (!$this->customer->isLogged()) {
            $this->response->redirect($this->url->link('account/login'));
            return;
        }
        $topic_id = (int)$this->request->get['topic_id'];
        $body = trim($this->request->post['body'] ?? '');
        if ($topic_id && $body) {
            $this->load->model('cms/mooc_forum');
            $this->model_cms_mooc_forum->addReply($topic_id, $this->customer->getId(), $body);
        }
        $this->response->redirect($this->url->link('cms/mooc_forum.topic', 'topic_id=' . $topic_id));
    }

    public function like(): void {
        if (!$this->customer->isLogged()) {
            $this->response->redirect($this->url->link('account/login'));
            return;
        }
        $reply_id = (int)($this->request->post['reply_id'] ?? 0);
        $topic_id = (int)($this->request->get['topic_id'] ?? 0);
        if ($reply_id) {
            $this->load->model('cms/mooc_forum');
            $this->model_cms_mooc_forum->toggleLike($reply_id, $this->customer->getId());
        }
        $this->response->redirect($this->url->link('cms/mooc_forum.topic', 'topic_id=' . $topic_id));
    }

    public function solution(): void {
        if (!$this->customer->isLogged()) {
            $this->response->redirect($this->url->link('account/login'));
            return;
        }
        $reply_id = (int)($this->request->post['reply_id'] ?? 0);
        $topic_id = (int)($this->request->get['topic_id'] ?? 0);
        if ($reply_id && $topic_id) {
            $this->load->model('cms/mooc_forum');
            $topic = $this->model_cms_mooc_forum->getTopic($topic_id);
            if ($topic && (int)$topic['customer_id'] === $this->customer->getId()) {
                $this->model_cms_mooc_forum->markSolution($topic_id, $reply_id);
            }
        }
        $this->response->redirect($this->url->link('cms/mooc_forum.topic', 'topic_id=' . $topic_id));
    }
}
