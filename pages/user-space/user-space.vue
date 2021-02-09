<template>
	<view>
	<!-- 	头部 -->
	<view class="flex align-center p-3 border-bottom border-light-secondary">
		<image src="/static/default.jpg" style="width: 180rpx;height: 180rpx;" class="rounded-circle"></image>
		
		<view class="pl-3 flex flex-column  flex-1">
			<view class="flex align-center">
				<view class="flex-1 flex flex-column align-center justify-center "><text class="font-lg font-weight-bold">1</text>
				<text class="font text-muted">粉丝</text></view>
				<view class="flex-1 flex flex-column align-center justify-center "><text class="font-lg font-weight-bold">1</text>
				<text class="font text-muted">粉丝</text></view>
				<view class="flex-1 flex flex-column align-center justify-center "><text class="font-lg font-weight-bold">1</text>
				<text class="font text-muted">粉丝</text></view>
			</view>
			<view class="flex align-center justify-center">
				<button type="primary" size="mini" class="bg-main" style="width: 400rpx;">关注</button>
			</view>
		</view>
	</view>
		
		<view class="flex align-center"  style="height: 100rpx;">
			<view class="flex-1  flex align-center justify-center font-md font-weight-normal" v-for="(item,index) in tabBars"
			 :key="index" @click="clickChange(index)" :class="tabBarIndex === index ? 'font-lg font-weight-bold text-main' : ''">{{item.name}} 
			</view>
		</view>
		<template v-if="tabBarIndex === 0">
			<view class="animated slow fadeIn">
			<view class="p-3 border-bottom">
				<view class="font-md">账号信息</view>
				<view class="font">账号年龄:12个月</view>
				<view class="font">账号id:1</view>
			</view>
			<view class="p-3 border-bottom">
				<view class="font-md">个人信息</view>
				<view class="font">星座:金牛座</view>
				<view class="font">职业：1</view>
				<view class="font">故乡：1</view>
				<view class="font">情感：1</view>
			</view>
			</view>
		</template>
		<template v-else>
			<view class="animated slow fadeIn">
			<common-list :item="item" :index="index" v-for="(item,index) in list" :key="index" @follow="follow" @doSupport="doSupport"></common-list>
			<divider></divider>
			<load-more :loadMore="loadmore"></load-more>
			</view>
		</template>
		
		<uni-popup ref="popup" type="top">
			<view class="flex align-center justify-center font-md border-bottom py-2" hover-class="bg-light">
				<text class="iconfont icon-sousuo mr-2">加入黑名单</text>
			</view>
			<view class="flex align-center justify-center font-md border-bottom py-2" hover-class="bg-light">
				<text class="iconfont icon-shanchu mr-2">聊天</text>
			</view>
		</uni-popup>
		
	</view>
</template>

<script>
	const demo = [{
			username:"昵称",
			userpic:"/static/default.jpg",
			newstime:"2019-10-30 下午04:30",
			isFollow:false,
			title:"我是标题",
			titlepic:"/static/demo/banner1.jpg",
			support:{
				type:"",
				support_count:0,
				unsupport_count:2
			},
			comment_count:2,
			share_num:2
		},
		{
			username:"杨雨",
			userpic:"/static/default.jpg",
			newstime:"2019-10-30 下午04:30",
			isFollow:false,
			title:"我是标题",
			titlepic:"",
			support:{
				type:"unsupport",
				support_count:1,
				unsupport_count:2
			},
			comment_count:2,
			share_num:2
		},
		{
			username:"杨雨",
			userpic:"/static/default.jpg",
			newstime:"2019-10-30 下午04:30",
			isFollow:false,
			title:"我是标题",
			titlepic:"",
			support:{
				type:"",
				support_count:1,
				unsupport_count:2
			},
			comment_count:2,
			share_num:2
		}]
	import commonList from "@/components/common/common-list.vue"
	import loadMore from "@/components/common/load-more.vue"
	import uniPopup from "../../components/uni-ui/uni-popup/uni-popup.vue"
	import uniPopupDialog from "../../components/uni-ui/uni-popup-dialog/uni-popup-dialog.vue"
	import uniPopupMessage from "../../components/uni-ui/uni-popup-message/uni-popup-message.vue"
	export default {
		components:{
			commonList,
			loadMore,
			uniPopup,
			uniPopupDialog,
			uniPopupMessage
		},
		data() {
			return {
				tabBarIndex: 0,
				tabBars: [{
						name: "主页",
					},
					{
						name: "帖子",
						list:demo,
						loadMore:"上拉加载更多..."
					}, {
						name: "动态",
						list:demo,
						loadMore:"上拉加载更多...",
					}
				]
			}
		},
		computed:{
			list(){
				return this.tabBars[this.tabBarIndex].list
			},
			loadmore(){
				return this.tabBars[this.tabBarIndex].loadMore
			}
		},
		onNavigationBarButtonTap() {
			this.$refs.popup.open()
		},
		methods: {
			clickChange(index) {
				this.tabBarIndex = index;
			},
			follow(e){
				//拿到选项卡对应的list
				let list = this.tabBars[this.tabBarIndex].list
				list[e].isFollow = true
				uni.showToast({title:"关注成功"})
			},
			doSupport(e){
				//拿到选项卡对应的list
				let list = this.tabBars[this.tabBarIndex].list
				let item = list[e.index]
				let msg = e.type === 'support' ? '顶' :'踩'
				if(item.support.type===''){
					item.support[e.type+'_count']++
				}else if(item.support.type==="support" && e.type==='unsupport'){
					item.support.support_count--;
					item.support.unsupport_count++
				}else if(item.support.type==="unsupport" && e.type==='support'){
					item.support.support_count++;
					item.support.unsupport_count--;
				}
				item.support.type = e.type
				uni.showToast({
					title:msg+"成功"
				})
			}
		}
	}
</script>

<style>

</style>
