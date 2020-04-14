<script lang="ts">
import { defineComponent } from '@vue/composition-api'
import { Context } from '@nuxt/types/app'

export default defineComponent({
  fetch({ redirect }: Context) {
    redirect({ name: 'activities-date' })
  }
})
</script>
