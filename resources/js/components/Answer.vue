<template>
    <div class="media post">

        <div v-show="!bodyHtml" class="media-body">
            <preloader></preloader><br>    
            <spinner></spinner><br>
        </div>

        <vote v-show="bodyHtml" :model="answer" name="answer"></vote>
        
        <div v-show="bodyHtml" class="media-body">
            <form v-show="authorize('modify', answer) && editing" @submit.prevent="update">
                <div class="form-group">
                    <m-editor :body="body" :name="uniqueName">
                        <textarea rows="10" v-model="body" class="form-control" required></textarea>
                    </m-editor>
                </div>
                <button class="btn btn-outline-primary" :disabled="isInvalid">
                    <preloader :small="true" v-if="$root.loading" :min-width="49.58"></preloader>
                    <span v-else>Update</span>
                </button>
                <button class="btn btn-outline-secondary" @click="cancel" type="button">Cancel</button>
            </form>
            <div v-show="!editing">
                <div :id="uniqueName" v-html="bodyHtml" ref="bodyHtml"></div>
                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">                            
                            <a v-if="authorize('modify', answer)" @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a> 
                            <button v-if="authorize('modify', answer)" @click="destroy" class="btn btn-sm btn-outline-danger">Delete</button>                                                                                                                 
                        </div>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4">
                        <user-info :model="answer" label="Answered"></user-info>
                    </div>
                </div>     
            </div>                           
        </div>
    </div>
</template>

<script>
import modification from '../mixins/modification';
import Preloader from './Preloader.vue';

export default {
    components: { Preloader },

    props: ['answer'],

    mixins: [modification],

    data () {
        return {            
            id: this.answer.id,
            body: this.answer.body,
            bodyHtml: this.answer.body_html,
            questionId: this.answer.question_id,
            beforeEditCache: {}
        }
    },

    computed: {
        isInvalid() {
            return this.body.length < 10;
        },

        endpoint() {
            return `/questions/${this.questionId}/answers/${this.id}`;
        },

        uniqueName() {
            return `answer-${this.id}`; 
        }
    },

    methods: {
        setEditCache () {
            this.beforeEditCache = {
                body: this.body
            };                                    
        },

        restoreFromCache () {
            this.body = this.beforeEditCache.body;            
        },

        payload () {
            return {
                body: this.body
            };
        },

        delete () {
            axios.delete(this.endpoint)
                .then(res => {
                    this.$toast.success(res.data.message, "Success", { timeout: 2000 });
                    this.$emit('deleted')
                });
        } 
    },
}
</script>