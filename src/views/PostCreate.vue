<template>
<div class="mother">
  <form @submit.prevent="createPost">
          <BaseSelect
            label="Select a category"
            :options="categories"
            v-model="post.category"
            :class="{ error: $v.post.category.$error }"
            @blur="$v.post.category.$touch()"
            />

          <template v-if="$v.post.category.$error">
            <p v-if="!$v.post.category.required" class="errorMessage">Category is required.</p>
          </template>
          <br>
          <input type="file" @change="onFileSelected" id="file" ref="file">
            <div class="mt-3">Selected image: {{ post.imageDir ? post.imageDir.name : '' }}</div>

          <h3>Name & describe your post</h3>

            <BaseInput
              label="Title"
              v-model="post.title"
              type="text"
              placeholder="Title"
              class="field"
              :class="{ error: $v.post.title.$error }"
              @blur="$v.post.title.$touch"
              />

            <template v-if="$v.post.title.$error">
              <p v-if="!$v.post.title.required" class="errorMessage">Title is required.</p>
            </template>

            <BaseInput
              label="Description"
              v-model="post.description"
              type="text"
              placeholder="Description"
              class="field"
              :class="{ error: $v.post.description.$error }"
              @blur="$v.post.description.$touch()"
              />

              <template v-if="$v.post.description.$error">
              <p v-if="!$v.post.description.required" class="errorMessage">Description is required.</p>
            </template>

            <h3>What's the price? (in USD)</h3>

            <BaseInput
              label="Price in USD"
              v-model="post.price"
              type="text"
              placeholder="price in USD"
              class="field"
              :class="{ erro: $v.post.price.$error }"
              @blur="$v.post.price.$touch"
            ></BaseInput>

            <template v-if="$v.post.price.$error">
              <p v-if="!$v.post.price.required" class="errorMessage">Price is required.</p>
            </template>

          <h3>What's the size?</h3>

          <BaseInput
            label="Size"
            v-model="post.size"
            type="text"
            placeholder="Size"
            class="field"
            :class="{ error: $v.post.size.$error }"
            @blur="$v.post.size.$touch()"
          />

          <template v-if="$v.post.size.$error">
              <p v-if="!$v.post.size.required" class="errorMessage">Size is required.</p>
            </template>

          <h3>Where u at?</h3>

          <BaseInput
            label="Location"
            v-model="post.location"
            type="text"
            placeholder="Location"
            class="field"
            :class="{ error: $v.post.location.$error }"
            @blur="$v.post.location.$touch()"
          />

          <template v-if="$v.post.location.$error">
              <p v-if="!$v.post.location.required" class="errorMessage">Location is required.</p>
            </template>
          <!-- <input type="submit" class="button -fill-gradient" value="Submit"/> -->
          <BaseButton
            type="submit"
            buttonClass="-fill-gradient"
            :disabled="$v.$anyError"
              >Submit</BaseButton>
              <p v-if="$v.$anyError" class="errorMessage">Please fill out the required field(S).</p>
        </form>
        </div>
</template>

<script>
import NProgress from 'nprogress'
import { required } from 'vuelidate/lib/validators'
import axios from 'axios'

export default {
  data () {
    return {
      post: this.createFreshEvent(),
      categories: this.$store.state.categories,
      file: null
    }
  },
  validations: {
    post: {
      category: { required },
      title: { required },
      description: { required },
      location: { required },
      size: { required },
      imageDir: { required },
      price: { required },
      user: { required }
    }
  },
  methods: {
    createPost () {
      this.$v.$touch()
      if (!this.$v.$invalid) {
        NProgress.start()
        this.$store
          .dispatch('post/createPost', this.post)
          .then(() => {
            this.$router.push({
              name: 'product',
              params: { id: this.post.id }
            })
            this.post = this.createFreshEventObject()
          }).catch(() => {
            NProgress.done()
          })
      }
    },

    createFreshEvent () {
      const user = this.$store.state.user.user
      const id = Math.floor(Math.random() * 10000000)
      return {
        id: id,
        user: user.name,
        category: '',
        title: '',
        description: '',
        location: '',
        size: '',
        imageDir: '',
        imageObj: {},
        price: ''
      }
    },

    onFileSelected (event) {
      this.file = this.$refs.file.files[0]
      this.post.imageDir = '../../static/' + event.target.files[0].name

      const formData = new FormData()
      formData.append('file', this.file)

      axios.post('http://localhost/FrugalX-master/FrugalX_API/api/post/ajaxfile.php', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
        .then(response => {
          if (!response.data) {
            alert('File not uploaded.')
          } else {
            alert('File uploaded successfully')
          }
        })
        .catch(error => {
          console.log(error)
        })
    }
  }
}
</script>
<style>
.field {
  margin-bottom: 24px;
}
.mother{
  box-sizing: border-box;
  width: 500px;
  padding: 0 20px 20px;
  margin: 0px auto;
  margin-top: 20px;
}
.errorMessage {
  color: red;
}

</style>
