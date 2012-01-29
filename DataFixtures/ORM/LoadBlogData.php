<?php

namespace Trsteel\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;

use Trsteel\BlogBundle\Entity\Category;
use Trsteel\BlogBundle\Entity\Post;

class LoadUserData implements FixtureInterface
{
    public function load($manager)
    {
        
        //create a random number of categories
        $category_count = rand(10, 15);
        
        $categories = array();
        for($i = 0; $i < $category_count; $i++) {
            $categories[$i] = new Category();
            $categories[$i]->setTitle('Category ' . ($i + 1));
            
            $manager->persist($categories[$i]);
        }
        
        $paragraphs = array(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque nibh metus, elementum et accumsan et, laoreet non dui. In vel nisl quis nunc vulputate hendrerit ac eu urna. Vivamus quam dolor, porttitor in commodo a, tempus vitae magna. Vivamus vitae erat dolor. Mauris eu laoreet augue. Aliquam venenatis lectus id massa feugiat nec condimentum nibh euismod. Pellentesque eget eros mi. Vestibulum sollicitudin adipiscing euismod. Sed a ligula metus, consequat faucibus libero. Fusce pellentesque placerat faucibus. In ullamcorper molestie nisi, sed eleifend felis bibendum vel. Sed laoreet, nulla at tincidunt eleifend, augue ipsum hendrerit justo, vitae congue diam est dictum mi. Curabitur magna neque, pretium sit amet porta sed, ultrices at augue.',
            'Morbi molestie varius placerat. Aliquam at diam dolor, vel tempor nisi. Duis diam leo, rhoncus scelerisque eleifend ut, malesuada non ante. Morbi bibendum velit dui, non vulputate nisl. Nunc placerat dolor vel dui dignissim quis volutpat ipsum accumsan. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In semper venenatis porttitor. Vivamus felis felis, hendrerit ac auctor vitae, placerat vel tortor.',
            'Curabitur vitae augue et turpis sodales bibendum. Sed egestas, diam in dapibus mattis, mi metus malesuada nisi, vulputate sodales nunc tellus eu mi. Aliquam bibendum rhoncus pellentesque. Aliquam a libero nibh. Mauris lobortis rutrum convallis. Proin laoreet nisl in mauris gravida sodales. Sed in sapien turpis. Maecenas pharetra ornare orci, a pretium orci tempor vestibulum. Nulla mollis pellentesque tempus. Pellentesque non sapien metus. Fusce sed elit nec ligula pellentesque placerat. Aliquam egestas, purus in gravida lacinia, nibh diam ornare erat, eget porta metus augue quis erat. Maecenas et justo turpis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;',
            'Aenean et massa magna. Curabitur egestas sollicitudin enim, eget egestas odio posuere non. In mattis, magna non sodales porttitor, dui urna iaculis sapien, et egestas nunc tellus eu est. Nam volutpat justo ut risus volutpat vestibulum. Suspendisse ligula mi, lacinia eget venenatis quis, pretium eu tellus. Ut ut libero nunc, quis lacinia est. Quisque ac nisi elit, in volutpat nisi.',
            'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus posuere gravida ante. Donec tempor, nulla eu ornare facilisis, ligula ligula sollicitudin eros, non tempor enim turpis faucibus magna. Nunc ac est eu enim faucibus mollis eu vel tellus. Nulla leo odio, accumsan at mattis eget, lacinia id diam. Sed odio mi, congue vitae consectetur id, venenatis vitae odio. Phasellus rutrum porta rutrum. Sed ornare sapien eget diam feugiat nec porta sem ornare. Praesent ligula mauris, aliquet et auctor eu, malesuada eget ligula. Vestibulum in nulla arcu, sit amet sagittis nisl. Nulla eget venenatis mi.',
            'Donec metus mauris, suscipit sed congue in, sagittis nec magna. Morbi at eros augue. Sed nec erat sed ipsum consectetur sagittis sed ac arcu. Sed porttitor arcu in est hendrerit vel volutpat dolor posuere. Mauris faucibus lorem mollis quam imperdiet venenatis non non odio. Nulla vitae dolor sit amet felis eleifend interdum. Maecenas porttitor arcu sed dolor dapibus vel scelerisque urna tristique. Praesent dapibus arcu et nisi imperdiet sit amet fringilla augue hendrerit. Vivamus sit amet mauris elit, et elementum nibh. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum vulputate dictum est, vitae consequat libero tristique non. Proin elementum justo vitae neque ultrices auctor. Morbi placerat, urna vel pellentesque porta, enim elit rhoncus tellus, eget vulputate orci sem malesuada lectus. Proin mollis enim et mauris pharetra cursus. Etiam erat elit, adipiscing sit amet facilisis a, tincidunt ut leo.',
            'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. In in risus mi, non scelerisque magna. Fusce justo lacus, semper vel adipiscing ut, sollicitudin id massa. Duis semper rhoncus enim imperdiet ullamcorper. Curabitur sed magna nec erat luctus aliquet in ut ligula. Nunc augue dui, consequat et rhoncus in, pellentesque cursus diam. In ultricies rhoncus est vel euismod. Vivamus quis tempus quam. Phasellus vitae ullamcorper orci. Suspendisse ut tellus dolor. Vivamus quam sem, fringilla at tempor eget, interdum nec arcu. Donec a ultrices sem. Praesent eu diam lorem. In sit amet fermentum nunc. Nullam vitae tellus nec felis tempor tincidunt id at massa. Morbi eu turpis bibendum ante vehicula mattis.',
            'Sed tincidunt, tellus eget adipiscing malesuada, sem orci placerat ante, ac varius nunc ipsum eu velit. Quisque ac mauris eu elit lacinia placerat ac porttitor lacus. Nam rhoncus, sem at vestibulum rutrum, elit lacus scelerisque leo, non pharetra erat lectus eget urna. In blandit tincidunt mauris, sit amet imperdiet elit vehicula a. Sed ultrices, odio id dignissim lacinia, nisi magna iaculis nulla, ac tempus est nunc ac odio. Donec mattis mauris sed ligula hendrerit a rutrum justo fermentum. Nam ut mi lacinia elit ultrices accumsan. Curabitur eu lectus nibh. Nullam libero est, aliquet nec adipiscing quis, pretium sit amet massa.',
            'Aliquam sed massa massa. In hac habitasse platea dictumst. Cras rhoncus, justo a ultrices congue, mauris quam mollis odio, vel aliquam nisl dolor sed justo. In facilisis iaculis consectetur. Sed vitae eros a diam varius auctor ac nec turpis. Proin in lacus nec eros adipiscing sagittis. Praesent rutrum urna imperdiet ipsum porttitor eget interdum elit faucibus. Integer ut sem vitae ipsum vestibulum lacinia. Duis ut diam lectus, at pellentesque arcu. Donec turpis libero, fringilla id porta vitae, tincidunt vitae nibh. Integer eu mi purus, ut bibendum ante. Donec lobortis, ipsum iaculis euismod lacinia, turpis magna dapibus sem, at malesuada velit ligula non lectus. Curabitur mattis leo at ligula semper eleifend.',
            'Quisque ut risus vel ante hendrerit ullamcorper. Nullam ullamcorper ornare ultricies. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Praesent in condimentum augue. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus lacus felis, pharetra a suscipit nec, volutpat nec nulla. Ut tristique congue augue. In sed massa et mi tempus pretium. Fusce in lectus eget neque pretium eleifend sed id odio. Aliquam ut magna vitae elit fringilla feugiat. Aenean at magna dui, non euismod massa. Aliquam tincidunt, purus vitae convallis suscipit, nulla ante pretium lorem, vel hendrerit tellus nisl a ipsum. Etiam condimentum arcu at tellus varius in mattis mi adipiscing. Integer eros felis, dignissim id volutpat lobortis, eleifend id massa.',
            'Posuere magna orci, eget semper augue. Suspendisse potenti. Ut in ligula vitae felis bibendum rhoncus et eu elit. In hac habitasse platea dictumst. Quisque laoreet felis vitae velit volutpat sollicitudin. Nam sagittis ipsum eget lorem consequat imperdiet. Morbi odio ipsum, sollicitudin luctus facilisis ac, elementum non tortor. Aenean in consectetur tellus. Phasellus pharetra venenatis dignissim. Sed sit amet nulla venenatis tellus vestibulum tincidunt. Nam tortor quam, mollis non fringilla eu, dapibus at est. Morbi consequat semper dapibus. Proin dictum congue est a ultrices.',
            'Et eros in metus rutrum tincidunt sed vitae quam. Integer quis pharetra eros. Nam orci elit, dictum a adipiscing non, pulvinar non ligula. Sed quis justo elit. Sed sed ultrices lectus. Aenean et nunc ipsum, vitae porta nulla. Phasellus a nibh quis urna suscipit tincidunt vel vitae leo. Mauris scelerisque, nulla quis imperdiet hendrerit, ligula nisl lobortis sem, ut ultricies neque orci et leo. Ut sit amet fermentum velit. Mauris lobortis blandit augue, vitae blandit mauris facilisis in. In hac habitasse platea dictumst. Sed porta mi sed massa suscipit rhoncus.',
            'Donec eget metus orci. Proin turpis arcu, commodo eget dapibus et, eleifend sed felis. Suspendisse non erat vel sapien fermentum volutpat. Etiam ornare, ante hendrerit lobortis aliquet, risus tellus pretium tellus, nec suscipit turpis mauris dapibus nunc. Aliquam est felis, scelerisque ut malesuada non, suscipit eu est. Vivamus tincidunt mattis mauris ut fringilla. Suspendisse convallis nibh et est gravida eget blandit nisl iaculis. Pellentesque facilisis orci eu lacus rhoncus aliquet eget eu lorem. In lacinia tortor a nunc aliquet tincidunt. Pellentesque eget iaculis lacus. Sed vel sapien ipsum, malesuada venenatis lectus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis luctus ligula sit amet enim molestie porta.',
            'Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Suspendisse a sapien dui, nec tincidunt sapien. Maecenas sit amet quam massa. Proin vulputate nunc ipsum, iaculis lacinia elit. Sed pulvinar consectetur dui, eget convallis libero posuere sed. Nam commodo justo sed augue convallis sodales. Maecenas magna nisl, fermentum ac eleifend eu, ornare et justo.',
            'Duis sit amet tortor non sapien aliquet laoreet. Aliquam luctus lectus felis. In sit amet nunc purus, vitae congue nisl. Donec non porta velit. Nullam dapibus elit sed nibh placerat eu eleifend sapien tincidunt. Vestibulum a mauris sit amet libero vulputate porta. Fusce cursus tincidunt varius. Curabitur pharetra ultrices augue, ornare ornare nulla semper nec. Nullam rutrum neque sit amet magna auctor rhoncus. Nam vitae suscipit ligula. In pharetra pharetra erat, at lobortis ligula suscipit vitae. Pellentesque at fringilla augue. Ut lacinia metus nec orci blandit sagittis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.',
            'Nisl eros, fringilla vel egestas at, rutrum interdum nisl. Duis faucibus, erat quis egestas euismod, dolor enim auctor tellus, eu convallis sapien justo ac elit. Nam vitae accumsan felis. Vivamus in auctor justo. Sed nisi dolor, posuere vitae consectetur ac, vehicula vitae sem. Pellentesque consectetur velit at ligula tempus vitae lobortis tortor volutpat. Maecenas malesuada bibendum convallis. Morbi pharetra enim ut nulla sagittis ornare. Suspendisse malesuada congue lobortis. Ut in nibh et nulla vulputate mollis et sit amet nibh. Proin tempor euismod neque sed aliquam. Morbi aliquet mauris nisi, ac fringilla mi. Donec faucibus dignissim facilisis. Nam vestibulum cursus erat, quis fringilla ligula facilisis non. Etiam sit amet lorem lacus, a volutpat nulla. Morbi ut arcu sem.',
            'Fusce massa velit, lacinia vitae molestie sit amet, hendrerit sit amet nisi. Pellentesque venenatis nisi nec orci placerat bibendum. Maecenas consectetur velit eget ipsum vestibulum ac suscipit orci tincidunt. Sed ut pulvinar mi. Etiam lobortis placerat quam, semper lobortis elit feugiat ac. Nunc dui quam, rutrum vitae lobortis vitae, semper a velit. Aliquam erat volutpat. In sapien lacus, malesuada sit amet semper eu, malesuada at mauris.',
            'Nulla facilisi. Cras elementum dui luctus quam blandit dapibus pulvinar dolor egestas. Mauris mollis consequat nisi a pretium. Aenean sed nibh nec turpis pulvinar congue. Aenean a tortor quis nisl pharetra eleifend eget quis metus. Proin quis purus dui, vel consequat tortor. Vestibulum vulputate consequat ipsum ut cursus. Morbi vestibulum purus a velit rhoncus vel pretium augue pharetra. Donec quis ante lectus, ac egestas lorem. Suspendisse odio risus, gravida eu faucibus non, luctus ac massa. Aenean vitae lorem urna, sed fermentum risus. Integer tempus, nulla sit amet semper cursus, sapien nisi suscipit orci, pretium facilisis magna nisi et eros. Aliquam vehicula est ac velit faucibus quis suscipit felis faucibus. Aenean dignissim cursus erat, et vehicula purus convallis at. Donec neque velit, luctus sit amet blandit at, condimentum ut nunc. Nam consequat, eros ac malesuada fermentum, tortor dolor vestibulum purus, ultrices malesuada nunc neque vitae velit.',
            'Blandit tincidunt felis, et tempus lacus fermentum a. Phasellus accumsan sem at nibh pulvinar ultricies. Integer eget metus eros, ac luctus lectus. Maecenas molestie, purus non volutpat sagittis, massa augue dictum enim, lobortis malesuada elit mauris vel odio. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur leo metus, tincidunt eu condimentum quis, pellentesque congue tortor. Praesent fringilla magna ipsum, sed cursus mauris. Nunc rhoncus iaculis justo at luctus. Pellentesque dolor quam, convallis sed placerat at, rhoncus at diam. In elementum, tellus non elementum posuere, metus lectus pellentesque libero, et elementum ante dui id velit. Nam pretium, quam id pulvinar consequat, odio sem cursus dui, eu euismod tellus quam nec eros. Curabitur posuere facilisis massa, et luctus est sollicitudin a.',
            'Semper pretium rhoncus aliquam, lobortis eget elit. Mauris dui sem, placerat ut varius eu, faucibus ullamcorper mauris. Quisque et quam est, sit amet rutrum turpis. Sed fringilla sem vel magna sodales quis rhoncus orci laoreet. Nullam vitae nisl non arcu vestibulum lobortis rutrum eu eros. Donec id nisi sed nibh pulvinar vehicula et et ligula. In hac habitasse platea dictumst. Maecenas scelerisque accumsan eleifend.',
        );
        
        //generate dates between now and 1 year ago.
        $date_start    = new \DateTime('-1 year');
        $date_end    = new \DateTime();
        
        $dates = array();
        for($i = 1; $i < 100; $i++) {
            $dates[] = rand($date_start->getTimestamp(), $date_end->getTimestamp());
        }
        
        //sort the dates so the titles increment correctly.
        asort($dates);
        
        $post_i = 0;
        foreach($dates as $unix_timestamp) {
            $post_i++;
            
            //randomly generate a body from the available paragraphs
            $paragraph_count = rand(1, (count($paragraphs) - 1));
            $body = '';
            for($i = 1; $i <= $paragraph_count; $i++) {
                $body .= '<p>' . $paragraphs[rand(1, (count($paragraphs) - 1))] . '</p>';
            }
            
            $date = new \DateTime();
            $date->setTimestamp($unix_timestamp);
            
            $post = new Post();
            $post->setDate($date)
                    ->setTitle('Post ' . ($post_i + 1))
                    ->setBody($body)
                    ->setIsEnabled(3 == rand(1, 3) ? false : true)# 1 in 3 chance the post will be disabled
            ;

            $post_categories = array();

            //randomly pick from the categories for this post
            $category_count = rand(1, (count($categories) - 1));
            for($i = 1; $i <= $category_count; $i++) {
                $cat_i = rand(1, (count($categories) - 1));
                
                $post_categories[$cat_i] = $cat_i;
            }
            
            foreach($post_categories as $cat_i) {
                $post->addCategory($categories[$cat_i]);
            }
            
            $manager->persist($post);
        }
        
        $manager->flush();
    }
}