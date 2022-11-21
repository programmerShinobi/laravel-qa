import QuestionsPage from '../pages/QuestionsPage.vue'
import LandingPage from '../pages/LandingPage.vue'
import HomePage from '../pages/HomePage.vue'
import QuestionPage from '../pages/QuestionPage.vue'
import MyPostsPage from '../pages/MyPostsPage.vue'
import NotFoundPage from '../pages/NotFoundPage.vue'
import CreateQuestionPage from '../pages/CreateQuestionPage.vue'
import EditQuestionPage from '../pages/EditQuestionPage.vue'

const routes = [
    {
        path: '/',
        component: LandingPage,
        name: 'home',
    },
    {
        path: '/home',
        component: HomePage,
        name: 'home',
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/questions',
        component: QuestionsPage,
        name: 'questions'
    },
    {
        path: '/questions/create',
        component: CreateQuestionPage,
        name: 'questions.create',
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/questions/:id/edit',
        component: EditQuestionPage,
        name: 'questions.edit',
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/my-posts',
        component: MyPostsPage,
        name: 'my-posts',
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/questions/:slug',
        component: QuestionPage,
        name: 'questions.show',
        props: true
    },
    {
        path: '/questions/:id',
        component: QuestionPage,
        name: 'questions.show',
        props: true,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '*',
        component: NotFoundPage
    }
]

export default routes
