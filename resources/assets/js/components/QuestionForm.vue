<template>
    <div>
        <form @submit.prevent="handleSubmit">
            <div class="form-group">
                <label for="question-title">Question Title</label>
                <input id="question-title" type="text" name="title" v-model="title" :class="errorClass('title')">
    
                <div v-if="errors.title" class="invalid-feedback">
                    <strong>{{ errors.title.toString()}}</strong>
                </div>
            </div>
            <div class="form-group">
                <label for="question-body">Explain you question</label>
                <m-editor :body="body" name="question-body">
                    <textarea id="question-body" name="body" rows="10" :class="errorClass('body')" v-model="body"></textarea>
        
                    <div v-if="errors.body" class="invalid-feedback">
                        <strong>{{ errors.body.toString() }}</strong>
                    </div>
                </m-editor>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-outline-primary btn-lg">{{ buttonText }}</button>
            </div>
        </form>
    </div>
</template>

<script>
import EventBus from '../event-bus'
import MEditor from './MEditor.vue'

export default {
    components: { MEditor },
    data () {
        return {
            title: '',
            body: '',           
            errors: {
                title: '',
                body: ''
            }            
        }
    },

    mounted () {
        EventBus.$on('error', errors => this.errors = errors)
    },

    computed: {
        buttonText () {
            return 'Ask Question'
        }
    },

    methods: {
        handleSubmit () {
            this.$emit('submitted', {
                title: this.title,
                body: this.body
            })
        },

        errorClass (column) {
            return [
                'form-control',
                this.errors[column] ? 'is-invalid' : ''
            ]
        },
    }
}
</script>