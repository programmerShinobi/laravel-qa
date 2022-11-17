<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <form class="card-body" v-show="authorize('modify', question) && editing" @submit.prevent="update">
                    <div class="card-title">
                        <input type="text" class="form-control form-control-lg" v-model="title" name="title" :class="errorClass('title')">
                        
                        <div v-if="errors.title" class="invalid-feedback">
                            <strong>{{ errors.title.toString()}}</strong>
                        </div>
                    </div>

                    <hr>

                    <div class="media">
                        <div class="media-body">
                            <div class="form-group">
                                <m-editor :body="body">
                                    <textarea rows="10" v-model="body" class="form-control" required name="body" :class="errorClass('body')"></textarea>

                                    <div v-if="errors.body" class="invalid-feedback">
                                        <strong>{{ errors.body.toString()}}</strong>
                                    </div>
                                </m-editor>
                            </div>
                            <button class="btn btn-outline-primary" :disabled="isInvalid">
                                <preloader :small="true" v-if="$root.loading" :min-width="49.58"></preloader>
                                <span v-else>Update</span>
                            </button>
                            <button class="btn btn-outline-secondary" @click="cancel" type="button">Cancel</button>
                        </div>
                    </div>
                </form>
                <div class="card-body" v-show="!editing">
                    <div class="card-title" v-show="bodyHtml">
                        <div class="d-flex align-items-center">
                            <h1>{{ title }}</h1>
                            <div class="ml-auto">
                                <router-link exact :to="{ name: 'questions' }" class="btn btn-outline-secondary">Back to all Questions</router-link>
                            </div>
                        </div>                        
                    </div>
                    <div class="card-title" v-show="!bodyHtml">
                        <div class="d-flex align-items-center">
                            <h1><preloader></preloader></h1>
                        </div>                        
                    </div>

                    <hr>

                    <div class="media">
                        <div v-show="!bodyHtml" class="media-body">
                                <spinner></spinner>
                        </div>
                        <vote v-show="bodyHtml" :model="question" name="question"></vote>
                        
                        <div v-show="bodyHtml" class="media-body">
                            <div v-html="bodyHtml" ref="bodyHtml"></div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="ml-auto">    
                                        <a v-if="authorize('modify', question)" @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>                                                     
                                        <button v-if="authorize('deleteQuestion', question)" @click="destroy" class="btn btn-sm btn-outline-danger">Delete</button>                                                                                 
                                    </div>
                                </div>
                                <div class="col-4"></div>
                                <div class="col-4">                                    
                                    <user-info :model="question" label="Asked"></user-info>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import modification from '../mixins/modification';
import highlight from '../mixins/highlight';
import EventBus from '../event-bus';
import Preloader from './Preloader.vue';

export default {
    components: { Preloader },

    mounted () {
        EventBus.$on('answers-count-changed', (count) => {
            this.question.answers_count = count;
        });
        EventBus.$on('error', errors => this.errors = errors);
        this.fetchQuestionBody();
    },

    props: ['question'],

    mixins: [modification, highlight],

    data () {
        return {
            id: this.question.id,
            slug: this.question.slug,
            title: this.question.title,
            body: this.question.body,
            bodyHtml: this.question.body_html,  
            errors: {
                title: '',
                body: '',
            },           
            beforeEditCache: {}
        }
    },

    computed: {
        isInvalid() {
            return this.body.length < 10 || this.title.length < 10;
        },

        endpoint() {
            if (window.location.pathname == `/questions/${this.id}`) {
                return `/questions/${this.id}`;
            } else {
                return `/questions/${this.slug}`;
            }
        },

    },

    methods: {
        setEditCache () {
            this.beforeEditCache = {
                title: this.title,
                body: this.body,
            };            
        },

        restoreFromCache () {
            this.body = this.beforeEditCache.body;
            this.title = this.beforeEditCache.title;
        },

        payload () {
            return {
                body: this.body,
                title: this.title
            };
        },

        delete () {
            axios.delete(this.endpoint)
                .then(({data}) => {
                    this.$toast.success(data.message, "Success", { timeout: 2000 });
                });

                setTimeout(() => {
                    window.location.href = "/questions";
                }, 3000);
            this.$router.push({ name: 'questions' });
        },

        errorClass (column) {
            return [
                'form-control',
                this.errors[column] ? 'is-invalid' : ''
            ]
        },

        fetchQuestionBody() {
            axios.get(this.endpoint)
                .then(() => this.highlight())
                .catch(err => console.log(err));
        }
    }
}
</script>
