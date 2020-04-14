import { ActionTree } from 'vuex'
import { AxiosResponse } from 'axios'
import { Code, CodeViewResponse } from './models'

export const actions: ActionTree<{}, {}> = {
  /**
   * Get provided codes from server
   */
  viewCode(_, { model }: { model: string }) {
    return this.$axios
      .get<any, AxiosResponse<CodeViewResponse>>(`/codes/${model}`, {
        cache: true
      })
      .then(res => {
        // Translate codes
        res.data.data.codes = res.data.data.codes.map((item: Code) => {
          item.text = this.$i18n.t(item.text).toString()
          return item
        })

        return res
      })
  }
}
