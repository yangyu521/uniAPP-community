<template>
	<view>
		<!-- 消息列表 -->
		<uni-popup></uni-popup>
		<template v-if="list.length > 0">
			<block v-for="(item,index) in list" :key="index">
			<msg-list :item="item" :index="index"></msg-list>
		</block>
		</template>
		
		<template v-else>
			<no-thing></no-thing>
		</template>
			<uni-popup ref="popup" type="top">
				<view class="flex align-center justify-center font-md border-bottom py-2" hover-class="bg-light" @click="popupEvent('friend')">
					<text class="iconfont icon-sousuo mr-2">添加好友</text>
				</view>
				<view class="flex align-center justify-center font-md border-bottom py-2" hover-class="bg-light" @click="popupEvent('clear')">
					<text class="iconfont icon-shanchu mr-2">清除列表</text>
				</view>
			</uni-popup>
		</view>
	</view>
</template>

<script>
	const demo = [{
					avatar:"/static/default.jpg", //头像
					username:"杨雨",//用户名
					update_time:"12:30",//发布时间
					data:"内容你还爱上的差别较大的不能是大V不金山毒霸帮我低价位v金额女我可烦恼我可就不发维保费其可交付全文翻", //内容
					noread:"1" //未读数
				},
				{
					avatar:"/static/default.jpg", //头像
					username:"yangxue",//用户名
					update_time:"12:30",//发布时间
					data:"内容你还爱上的差别较大的不能是大V不金山毒霸帮我低价位v金额女我可烦恼我可就不发维保费其可交付全文翻", //内容
					noread:"1" //未读数
				},
				{
					avatar:"/static/default.jpg", //头像
					username:"昵称",//用户名
					update_time:"12:30",//发布时间
					data:"内容你还爱上的差别较大的不能是大V不金山毒霸帮我低价位v金额女我可烦恼我可就不发维保费其可交付全文翻", //内容
					noread:"1" //未读数
				},
				{
					avatar:"/static/default.jpg", //头像
					username:"昵称",//用户名
					update_time:"12:30",//发布时间
					data:"内容你还爱上的差别较大的不能是大V不金山毒霸帮我低价位v金额女我可烦恼我可就不发维保费其可交付全文翻", //内容
					noread:"5" //未读数
				}]
	import msgList from "@/components/msg/msg-list.vue"
	import noThing from "@/components/common/no-thing.vue"
	import uniPopup from "../../components/uni-ui/uni-popup/uni-popup.vue"
	import uniPopupDialog from "../../components/uni-ui/uni-popup-dialog/uni-popup-dialog.vue"
	import uniPopupMessage from "../../components/uni-ui/uni-popup-message/uni-popup-message.vue"
	export default {
		data() {
			return {
				list:[]
			}
		},
		components:{
			msgList,
			noThing,
			uniPopup,
			uniPopupMessage
		},
		onLoad(){
				this.list = demo;
		},
		
		methods: {
			refresh(){
				setTimeout(()=>{
					this.list = demo;
					//停止下拉刷新
					uni.stopPullDownRefresh()
				},2000)
			},
			open(){
			         this.$refs.popup.open()
			      },
				  popupEvent(e){
					  switch (e){
						 case 'friend' :
						uni.navigateTo({
							url:"../search/search?type=user"
						})
						 break;
						 case 'clear' :
						 console.log('clear')
						 break;
					  }
				  }
		},
		onPullDownRefresh(){
			this.refresh();
		},
		onNavigationBarButtonTap(e){
			switch (e.index){
				case 0 :
				//关闭弹出层
				uni.navigateTo({
					url:"../user-list/user-list"
				})
				break;
				case 1:
				this.$refs.popup.open()
			}
		}
		
	}
</script>

<style>

</style>
