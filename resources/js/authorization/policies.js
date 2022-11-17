export default {
    see (user) {
        return user.id === user.id;
    },

    verified (user) {
        return user.email.verified_at === 1;
    },

    modify (user, model) {
        return user.id === model.user.id;
    },

    accept (user, answer) {
        return user.id === answer.question_user_id;
    },

    deleteQuestion (user, question) {
        return user.id === question.user.id && question.answers_count < 1;
    }
}