<template>
	<view>
		<common-list :item="info" :isdetail="isdetail" @doComment="doComment" @doShare="doShare" @follow="follow" @doSupport="doSupport">
			<view>
				{{info.content}}
			</view>
			<image v-for="(item,index) in info.images" :src="item.url" mode="widthFix" class="w-100" @click="preview(index)"></image>
		</common-list>
		<five-commentlist :commentList="commentList"></five-commentlist>
		<!-- 占位 -->
		<view style="height: 100rpx;">
			<bottom-input @submit="submit"></bottom-input>
		</view>
	    <more-share ref="share"></more-share>
	</view>
</template>

<script>
	import commonList from "@/components/common/common-list.vue"
	import bottomInput from "@/components/common/bottom-input.vue"
	import fiveCommentlist from "@/components/common/five-commentlist.vue"
	import moreShare from "@/components/common/more-share.vue"
	export default {
		components: {
			commonList,
			bottomInput,
			fiveCommentlist,
			moreShare
		},
		onNavigationBarButtonTap() {
			this.$refs.share.open();
		},
		onBackPress() {
			this.$refs.share.close()
		},
		data() {
			return {
				shareList:[{
					icon:"icon-QQ",
					color:"bg-primary",
					name:"QQ好友"
				},
				{
					icon:"icon-QQ",
					color:"bg-primary",
					name:"QQ好友"
				},
				{
					icon:"icon-QQ",
					color:"bg-primary",
					name:"QQ好友"
				},
				{
					icon:"icon-QQ",
					color:"bg-primary",
					name:"QQ好友"
				}],
				isdetail: true,
				commentList: [{
						COMMENT_TIME: "2020-07-07 10:33:29",
						FIRSTNICKNAME: "网友1271622",
						IS_PRAISE: null,
						TAG: "",
						COMMENT: "",
						PRAISE_NUM: 0,
						CANDELETE: 1,
						HEADIMGURL: "http://img2.imgtn.bdimg.com/it/u=2659658743,1944621503&fm=26&gp=0.jpg",
						SECONDNICKNAME: null
					},
					{
						COMMENT_TIME: "2020-07-07 10:32:52",
						FIRSTNICKNAME: "网友3778839",
						IS_PRAISE: null,
						TAG: "",
						COMMENT: "",
						PRAISE_NUM: 0,
						CANDELETE: 0,
						HEADIMGURL: "http://pic1.zhimg.com/50/v2-e88c0426c1ccc429dbedea3d01e5fac2_hd.jpg",
						PARENTID: "1",
						SECONDNICKNAME: null

					}
				],
				info: {
					username: "昵称",
					userpic: "/static/default.jpg",
					newstime: "2019-10-30 下午04:30",
					isFollow: false,
					title: "我是标题",
					titlepic: "/static/demo/banner1.jpg",
					support: {
						type: "",
						support_count: 0,
						unsupport_count: 2
					},
					comment_count: 2,
					share_num: 2,
					content: "年少不知富婆香，最后到老空惆怅",
					images: [{
							url: "https://img.alicdn.com/tfscom/i1/O1CN01B50Ryk1jUrY0gjoE5_!!0-dgshop.jpg_180x180q90.jpg_.webp"
						},
						{
							url: "https://gtms03.alicdn.com/tps/i3/TB1cZn6KXXXXXatXpXXRBft6FXX-230-230.jpg_.webp"
						}
					]
				}
			}
		},
		onLoad(e) {
			if (e.detail) {
				this.__init(JSON.parse(e.detail))
			}
		},
		computed: {
			imagesList() {
				return this.info.images.map(item => item.url)
			}
		},
		methods: {
			//修改标题
			__init(data) {
				uni.setNavigationBarTitle({
					title: data.title
				})
				//请求API
			},
			doComment() {
				console.log("doComment")
			},
			doShare() {
				console.log("doShare")
			},
			follow() {
				this.info.isFollow = true
			},
			doSupport(e) {
				if (this.info.support.type === e.type) {
					return uni.showToast({
						title: '您已经操作过了'
					})
				}
				let msg = e.type === 'support' ? '顶' : '踩'
				if (this.info.support.type === '') {
					this.info.support[e.type + '_count']++
				} else if (this.info.support.type === 'support' && e.type === 'unsupport') {
					//顶-1 
					this.info.support.support_count--
					//踩+1
					this.info.support.unsupport_count++
				} else if (this.info.support.type === 'unsupport' && e.type === 'support') {
					//踩-1
					this.info.support.unsupport_count--
					//顶+1
					this.info.support.support_count++
				}
				this.info.support.type = e.type;
				uni.showToast({
					title: msg
				})
			},
			//预览图片
			preview(index) {
				uni.previewImage({
					current: index,
					urls: this.imagesList,
				});
			},
			submit(data) {
				console.log(data)
			}

		}
	}
</script>

<style>

</style>
